---
Title: Быстрые операции с очень большими строками
Author: Peter Morris, support@droopyeyes.com
Date: 01.01.2007
---


Быстрые операции с очень большими строками
==========================================

FastStrings.pas

    //==================================================
    //All code herein is copyrighted by
    //Peter Morris
    //-----
    //Do not alter / remove this copyright notice
    //Email me at : support@droopyeyes.com
    //
    //The homepage for this library is http://www.droopyeyes.com
    //
    // CURRENT VERSION V3.2
    //
    //(Check out www.HowToDoThings.com for Delphi articles !)
    //(Check out www.stuckindoors.com if you need a free events page on your site !)
    //==================================================
     
     
    unit FastStrings;
     
    interface
     
    uses
       {$IFNDEF LINUX}
         Windows,
       {$ENDIF}
       SysUtils;
     
    //This TYPE declaration will become apparent later
    type
      TBMJumpTable = array[0..255] of Integer;
      TFastPosProc = function (const aSource, aFind: Pointer; const aSourceLen, aFindLen: Integer; var JumpTable: TBMJumpTable): Pointer;
      TFastPosIndexProc = function (const aSourceString, aFindString: string; const aSourceLen, aFindLen, StartPos: Integer; var JumpTable: TBMJumpTable): Integer;
      TFastTagReplaceProc = procedure (var Tag: string; const UserData: Integer);
     
     
    //Boyer-Moore routines
    procedure MakeBMTable(Buffer: PChar; BufferLen: Integer; var JumpTable: TBMJumpTable);
    procedure MakeBMTableNoCase(Buffer: PChar; BufferLen: Integer; var JumpTable: TBMJumpTable);
    function BMPos(const aSource, aFind: Pointer; const aSourceLen, aFindLen: Integer; var JumpTable: TBMJumpTable): Pointer;
    function BMPosNoCase(const aSource, aFind: Pointer; const aSourceLen, aFindLen: Integer; var JumpTable: TBMJumpTable): Pointer;
     
    function FastAnsiReplace(const S, OldPattern, NewPattern: string; Flags: TReplaceFlags): string;
    procedure FastCharMove(const Source; var Dest; Count : Integer);
    function FastCharPos(const aSource : string; const C: Char; StartPos : Integer): Integer;
    function FastCharPosNoCase(const aSource : string; C: Char; StartPos : Integer): Integer;
    function FastPos(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    function FastPosNoCase(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    function FastPosBack(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    function FastPosBackNoCase(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    function FastReplace(const aSourceString : string; const aFindString, aReplaceString : string;
      CaseSensitive : Boolean = False) : string;
    function FastTagReplace(const SourceString, TagStart, TagEnd: string;
      FastTagReplaceProc: TFastTagReplaceProc; const UserData: Integer): string;
    function SmartPos(const SearchStr,SourceStr : string;
                      const CaseSensitive : Boolean = TRUE;
                      const StartPos : Integer = 1;
                      const ForwardSearch : Boolean = TRUE) : Integer;
     
    implementation
     
    const
      cDeltaSize = 1.5;
     
    var
      GUpcaseTable : array[0..255] of char;
      GUpcaseLUT: Pointer;
     
    //MakeBMJumpTable takes a FindString and makes a JumpTable
    procedure MakeBMTable(Buffer: PChar; BufferLen: Integer; var JumpTable: TBMJumpTable);
    begin
      if BufferLen = 0 then raise Exception.Create('BufferLen is 0');
      asm
            push    EDI
            push    ESI
            mov     EDI, JumpTable
            mov     EAX, BufferLen
            mov     ECX, $100
            REPNE   STOSD
            mov     ECX, BufferLen
            mov     EDI, JumpTable
            mov     ESI, Buffer
            dec     ECX
            xor     EAX, EAX
    @@loop:
            mov     AL, [ESI]
            lea     ESI, ESI + 1
            mov     [EDI + EAX * 4], ECX
            dec     ECX
            jg      @@loop
     
            pop     ESI
            pop     EDI
      end;
    end;
     
    procedure MakeBMTableNoCase(Buffer: PChar; BufferLen: Integer; var JumpTable: TBMJumpTable);
    begin
      if BufferLen = 0 then raise Exception.Create('BufferLen is 0');
      asm
            push    EDI
            push    ESI
     
            mov     EDI, JumpTable
            mov     EAX, BufferLen
            mov     ECX, $100
            REPNE   STOSD
     
            mov     EDX, GUpcaseLUT
            mov     ECX, BufferLen
            mov     EDI, JumpTable
            mov     ESI, Buffer
            dec     ECX
            xor     EAX, EAX
    @@loop:
            mov     AL, [ESI]
            lea     ESI, ESI + 1
            mov     AL, [EDX + EAX]
            mov     [EDI + EAX * 4], ECX
            dec     ECX
            jg      @@loop
            pop     ESI
            pop     EDI
      end;
    end;
     
    function BMPos(const aSource, aFind: Pointer; const aSourceLen, aFindLen: Integer; var JumpTable: TBMJumpTable): Pointer;
    var
      LastPos: Pointer;
    begin
      LastPos := Pointer(Integer(aSource) + aSourceLen - 1);
      asm
            push    ESI
            push    EDI
            push    EBX
     
            mov     EAX, aFindLen
            mov     ESI, aSource
            lea     ESI, ESI + EAX - 1
            std
            mov     EBX, JumpTable
     
    @@comparetext:
            cmp     ESI, LastPos
            jg      @@NotFound
            mov     EAX, aFindLen
            mov     EDI, aFind
            mov     ECX, EAX
            push    ESI //Remember where we are
            lea     EDI, EDI + EAX - 1
            xor     EAX, EAX
    @@CompareNext:
            mov     al, [ESI]
            cmp     al, [EDI]
            jne     @@LookAhead
            lea     ESI, ESI - 1
            lea     EDI, EDI - 1
            dec     ECX
            jz      @@Found
            jmp     @@CompareNext
     
    @@LookAhead:
            //Look up the char in our Jump Table
            pop     ESI
            mov     al, [ESI]
            mov     EAX, [EBX + EAX * 4]
            lea     ESI, ESI + EAX
            jmp     @@CompareText
     
    @@NotFound:
            mov     Result, 0
            jmp     @@TheEnd
    @@Found:
            pop     EDI //We are just popping, we don't need the value
            inc     ESI
            mov     Result, ESI
    @@TheEnd:
            cld
            pop     EBX
            pop     EDI
            pop     ESI
      end;
    end;
     
    function BMPosNoCase(const aSource, aFind: Pointer; const aSourceLen, aFindLen: Integer; var JumpTable: TBMJumpTable): Pointer;
    var
      LastPos: Pointer;
    begin
      LastPos := Pointer(Integer(aSource) + aSourceLen - 1);
      asm
            push    ESI
            push    EDI
            push    EBX
     
            mov     EAX, aFindLen
            mov     ESI, aSource
            lea     ESI, ESI + EAX - 1
            std
            mov     EDX, GUpcaseLUT
     
    @@comparetext:
            cmp     ESI, LastPos
            jg      @@NotFound
            mov     EAX, aFindLen
            mov     EDI, aFind
            push    ESI //Remember where we are
            mov     ECX, EAX
            lea     EDI, EDI + EAX - 1
            xor     EAX, EAX
    @@CompareNext:
            mov     al, [ESI]
            mov     bl, [EDX + EAX]
            mov     al, [EDI]
            cmp     bl, [EDX + EAX]
            jne     @@LookAhead
            lea     ESI, ESI - 1
            lea     EDI, EDI - 1
            dec     ECX
            jz      @@Found
            jmp     @@CompareNext
     
    @@LookAhead:
            //Look up the char in our Jump Table
            pop     ESI
            mov     EBX, JumpTable
            mov     al, [ESI]
            mov     al, [EDX + EAX]
            mov     EAX, [EBX + EAX * 4]
            lea     ESI, ESI + EAX
            jmp     @@CompareText
     
    @@NotFound:
            mov     Result, 0
            jmp     @@TheEnd
    @@Found:
            pop     EDI //We are just popping, we don't need the value
            inc     ESI
            mov     Result, ESI
    @@TheEnd:
            cld
            pop     EBX
            pop     EDI
            pop     ESI
      end;
    end;
     
     
    //NOTE : FastCharPos and FastCharPosNoCase do not require you to pass the length
    //       of the string, this was only done in FastPos and FastPosNoCase because
    //       they are used by FastReplace many times over, thus saving a LENGTH()
    //       operation each time.  I can't see you using these two routines for the
    //       same purposes so I didn't do that this time !
    function FastCharPos(const aSource : string; const C: Char; StartPos : Integer) : Integer;
    var
      L                           : Integer;
    begin
      //If this assert failed, it is because you passed 0 for StartPos, lowest value is 1 !!
      Assert(StartPos > 0);
     
      Result := 0;
      L := Length(aSource);
      if L = 0 then exit;
      if StartPos > L then exit;
      Dec(StartPos);
      asm
          PUSH EDI                 //Preserve this register
     
          mov  EDI, aSource        //Point EDI at aSource
          add  EDI, StartPos
          mov  ECX, L              //Make a note of how many chars to search through
          sub  ECX, StartPos
          mov  AL,  C              //and which char we want
        @Loop:
          cmp  Al, [EDI]           //compare it against the SourceString
          jz   @Found
          inc  EDI
          dec  ECX
          jnz  @Loop
          jmp  @NotFound
        @Found:
          sub  EDI, aSource        //EDI has been incremented, so EDI-OrigAdress = Char pos !
          inc  EDI
          mov  Result,   EDI
        @NotFound:
     
          POP  EDI
      end;
    end;
     
    function FastCharPosNoCase(const aSource : string; C: Char; StartPos : Integer) : Integer;
    var
      L                           : Integer;
    begin
      Result := 0;
      L := Length(aSource);
      if L = 0 then exit;
      if StartPos > L then exit;
      Dec(StartPos);
      if StartPos < 0 then StartPos := 0;
     
      asm
          PUSH EDI                 //Preserve this register
          PUSH EBX
          mov  EDX, GUpcaseLUT
     
          mov  EDI, aSource        //Point EDI at aSource
          add  EDI, StartPos
          mov  ECX, L              //Make a note of how many chars to search through
          sub  ECX, StartPos
     
          xor  EBX, EBX
          mov  BL,  C
          mov  AL, [EDX+EBX]
        @Loop:
          mov  BL, [EDI]
          inc  EDI
          cmp  Al, [EDX+EBX]
          jz   @Found
          dec  ECX
          jnz  @Loop
          jmp  @NotFound
        @Found:
          sub  EDI, aSource        //EDI has been incremented, so EDI-OrigAdress = Char pos !
          mov  Result,   EDI
        @NotFound:
     
          POP  EBX
          POP  EDI
      end;
    end;
     
    //The first thing to note here is that I am passing the SourceLength and FindLength
    //As neither Source or Find will alter at any point during FastReplace there is
    //no need to call the LENGTH subroutine each time !
    function FastPos(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    var
      JumpTable: TBMJumpTable;
    begin
      //If this assert failed, it is because you passed 0 for StartPos, lowest value is 1 !!
      Assert(StartPos > 0);
      if aFindLen < 1 then begin
        Result := 0;
        exit;
      end;
      if aFindLen > aSourceLen then begin
        Result := 0;
        exit;
      end;
     
      MakeBMTable(PChar(aFindString), aFindLen, JumpTable);
      Result := Integer(BMPos(PChar(aSourceString) + (StartPos - 1), PChar(aFindString),aSourceLen - (StartPos-1), aFindLen, JumpTable));
      if Result > 0 then
        Result := Result - Integer(@aSourceString[1]) +1;
    end;
     
    function FastPosNoCase(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    var
      JumpTable: TBMJumpTable;
    begin
      //If this assert failed, it is because you passed 0 for StartPos, lowest value is 1 !!
      Assert(StartPos > 0);
      if aFindLen < 1 then begin
        Result := 0;
        exit;
      end;
      if aFindLen > aSourceLen then begin
        Result := 0;
        exit;
      end;
     
      MakeBMTableNoCase(PChar(AFindString), aFindLen, JumpTable);
      Result := Integer(BMPosNoCase(PChar(aSourceString) + (StartPos - 1), PChar(aFindString),aSourceLen - (StartPos-1), aFindLen, JumpTable));
      if Result > 0 then
        Result := Result - Integer(@aSourceString[1]) +1;
    end;
     
    function FastPosBack(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    var
      SourceLen : Integer;
    begin
      if aFindLen < 1 then begin
        Result := 0;
        exit;
      end;
      if aFindLen > aSourceLen then begin
        Result := 0;
        exit;
      end;
     
      if (StartPos = 0) or  (StartPos + aFindLen > aSourceLen) then
        SourceLen := aSourceLen - (aFindLen-1)
      else
        SourceLen := StartPos;
     
      asm
              push ESI
              push EDI
              push EBX
     
              mov EDI, aSourceString
              add EDI, SourceLen
              Dec EDI
     
              mov ESI, aFindString
              mov ECX, SourceLen
              Mov  Al, [ESI]
     
        @ScaSB:
              cmp  Al, [EDI]
              jne  @NextChar
     
        @CompareStrings:
              mov  EBX, aFindLen
              dec  EBX
              jz   @FullMatch
     
        @CompareNext:
              mov  Ah, [ESI+EBX]
              cmp  Ah, [EDI+EBX]
              Jnz  @NextChar
     
        @Matches:
              Dec  EBX
              Jnz  @CompareNext
     
        @FullMatch:
              mov  EAX, EDI
              sub  EAX, aSourceString
              inc  EAX
              mov  Result, EAX
              jmp  @TheEnd
        @NextChar:
              dec  EDI
              dec  ECX
              jnz  @ScaSB
     
              mov  Result,0
     
        @TheEnd:
              pop  EBX
              pop  EDI
              pop  ESI
      end;
    end;
     
     
    function FastPosBackNoCase(const aSourceString, aFindString : string; const aSourceLen, aFindLen, StartPos : Integer) : Integer;
    var
      SourceLen : Integer;
    begin
      if aFindLen < 1 then begin
        Result := 0;
        exit;
      end;
      if aFindLen > aSourceLen then begin
        Result := 0;
        exit;
      end;
     
      if (StartPos = 0) or  (StartPos + aFindLen > aSourceLen) then
        SourceLen := aSourceLen - (aFindLen-1)
      else
        SourceLen := StartPos;
     
      asm
              push ESI
              push EDI
              push EBX
     
              mov  EDI, aSourceString
              add  EDI, SourceLen
              Dec  EDI
     
              mov  ESI, aFindString
              mov  ECX, SourceLen
     
              mov  EDX, GUpcaseLUT
              xor  EBX, EBX
     
              mov  Bl, [ESI]
              mov  Al, [EDX+EBX]
     
        @ScaSB:
              mov  Bl, [EDI]
              cmp  Al, [EDX+EBX]
              jne  @NextChar
     
        @CompareStrings:
              PUSH ECX
              mov  ECX, aFindLen
              dec  ECX
              jz   @FullMatch
     
        @CompareNext:
              mov  Bl, [ESI+ECX]
              mov  Ah, [EDX+EBX]
              mov  Bl, [EDI+ECX]
              cmp  Ah, [EDX+EBX]
              Jz   @Matches
     
        //Go back to findind the first char
              POP  ECX
              Jmp  @NextChar
     
        @Matches:
              Dec  ECX
              Jnz  @CompareNext
     
        @FullMatch:
              POP  ECX
     
              mov  EAX, EDI
              sub  EAX, aSourceString
              inc  EAX
              mov  Result, EAX
              jmp  @TheEnd
        @NextChar:
              dec  EDI
              dec  ECX
              jnz  @ScaSB
     
              mov  Result,0
     
        @TheEnd:
              pop  EBX
              pop  EDI
              pop  ESI
      end;
    end;
     
    //My move is not as fast as MOVE when source and destination are both
    //DWord aligned, but certainly faster when they are not.
    //As we are moving characters in a string, it is not very likely at all that
    //both source and destination are DWord aligned, so moving bytes avoids the
    //cycle penality of reading/writing DWords across physical boundaries
    procedure FastCharMove(const Source; var Dest; Count : Integer);
    asm
    //Note:  When this function is called, delphi passes the parameters as follows
    //ECX = Count
    //EAX = Const Source
    //EDX = Var Dest
     
            //If no bytes to copy, just quit altogether, no point pushing registers
            cmp   ECX,0
            Je    @JustQuit
     
            //Preserve the critical delphi registers
            push  ESI
            push  EDI
     
            //move Source into ESI  (generally the SOURCE register)
            //move Dest into EDI (generally the DEST register for string commands)
            //This may not actually be neccessary, as I am not using MOVsb etc
            //I may be able just to use EAX and EDX, there may be a penalty for
            //not using ESI, EDI but I doubt it, this is another thing worth trying !
            mov   ESI, EAX
            mov   EDI, EDX
     
            //The following loop is the same as repNZ MovSB, but oddly quicker !
        @Loop:
            //Get the source byte
            Mov   AL, [ESI]
            //Point to next byte
            Inc   ESI
            //Put it into the Dest
            mov   [EDI], AL
            //Point dest to next position
            Inc   EDI
            //Dec ECX to note how many we have left to copy
            Dec   ECX
            //If ECX <> 0 then loop
            Jnz   @Loop
     
            //Another optimization note.
            //Many people like to do this
     
            //Mov AL, [ESI]
            //Mov [EDI], Al
            //Inc ESI
            //Inc ESI
     
            //There is a hidden problem here, I wont go into too much detail, but
            //the pentium can continue processing instructions while it is still
            //working out the result of INC ESI or INC EDI
            //(almost like a multithreaded CPU)
            //if, however, you go to use them while they are still being calculated
            //the processor will stop until they are calculated (a penalty)
            //Therefore I alter ESI and EDI as far in advance as possible of using them
     
            //Pop the critical Delphi registers that we have altered
            pop   EDI
            pop   ESI
        @JustQuit:
    end;
     
    function FastAnsiReplace(const S, OldPattern, NewPattern: string;
      Flags: TReplaceFlags): string;
    var
      BufferSize, BytesWritten: Integer;
      SourceString, FindString: string;
      ResultPChar: PChar;
      FindPChar, ReplacePChar: PChar;
      SPChar, SourceStringPChar, PrevSourceStringPChar: PChar;
      FinalSourceMarker: PChar;
      SourceLength, FindLength, ReplaceLength, CopySize: Integer;
      FinalSourcePosition: Integer;
    begin
      //Set up string lengths
      BytesWritten := 0;
      SourceLength := Length(S);
      FindLength := Length(OldPattern);
      ReplaceLength := Length(NewPattern);
      //Quick exit
      if (SourceLength = 0) or (FindLength = 0) or
        (FindLength > SourceLength) then
      begin
        Result := S;
        Exit;
      end;
     
      //Set up the source string and find string
      if rfIgnoreCase in Flags then
      begin
        SourceString := AnsiUpperCase(S);
        FindString := AnsiUpperCase(OldPattern);
      end else
      begin
        SourceString := S;
        FindString := OldPattern;
      end;
     
      //Set up the result buffer size and pointers
      try
        if ReplaceLength <= FindLength then
          //Result cannot be larger, only same size or smaller
          BufferSize := SourceLength
        else
          //Assume a source string made entired of the sub string
          BufferSize := (SourceLength * ReplaceLength) div
        FindLength;
     
        //10 times is okay for starters. We don't want to
        //go allocating much more than we need.
        if BufferSize > (SourceLength * 10) then
          BufferSize := SourceLength * 10;
      except
        //Oops, integer overflow! Better start with a string
        //of the same size as the source.
        BufferSize := SourceLength;
      end;
      SetLength(Result, BufferSize);
      ResultPChar := @Result[1];
     
      //Set up the pointers to S and SourceString
      SPChar := @S[1];
      SourceStringPChar := @SourceString[1];
      PrevSourceStringPChar := SourceStringPChar;
      FinalSourceMarker := @SourceString[SourceLength - (FindLength - 1)];
     
      //Set up the pointer to FindString
      FindPChar := @FindString[1];
     
      //Set the pointer to ReplaceString
      if ReplaceLength > 0 then
        ReplacePChar := @NewPattern[1]
      else
        ReplacePChar := nil;
     
      //Replace routine
      repeat
        //Find the sub string
        SourceStringPChar := AnsiStrPos(PrevSourceStringPChar,
        FindPChar);
        if SourceStringPChar = nil then Break;
        //How many characters do we need to copy before
        //the string occurs
        CopySize := SourceStringPChar - PrevSourceStringPChar;
     
        //Check we have enough space in our Result buffer
        if CopySize + ReplaceLength > BufferSize - BytesWritten then
        begin
          BufferSize := Trunc((BytesWritten + CopySize + ReplaceLength) * cDeltaSize);
          SetLength(Result, BufferSize);
          ResultPChar := @Result[BytesWritten + 1];
        end;
     
        //Copy the preceeding characters to our result buffer
        Move(SPChar^, ResultPChar^, CopySize);
        Inc(BytesWritten, CopySize);
        //Advance the copy position of S
        Inc(SPChar, CopySize + FindLength);
        //Advance the Result pointer
        Inc(ResultPChar, CopySize);
        //Copy the replace string into the Result buffer
        if Assigned(ReplacePChar) then
        begin
          Move(ReplacePChar^, ResultPChar^, ReplaceLength);
          Inc(ResultPChar, ReplaceLength);
          Inc(BytesWritten, ReplaceLength);
        end;
     
        //Fake delete the start of the source string
        PrevSourceStringPChar := SourceStringPChar + FindLength;
      until (PrevSourceStringPChar > FinalSourceMarker) or
        not (rfReplaceAll in Flags);
     
      FinalSourcePosition := Integer(SPChar - @S[1]);
      CopySize := SourceLength - FinalSourcePosition;
      SetLength(Result, BytesWritten + CopySize);
      if CopySize > 0 then
        Move(SPChar^, Result[BytesWritten + 1], CopySize);
    end;
     
    function FastReplace(const aSourceString : string; const aFindString, aReplaceString : string;
       CaseSensitive : Boolean = False) : string;
    var
      PResult                     : PChar;
      PReplace                    : PChar;
      PSource                     : PChar;
      PFind                       : PChar;
      PPosition                   : PChar;
      CurrentPos,
      BytesUsed,
      lResult,
      lReplace,
      lSource,
      lFind                       : Integer;
      Find                        : TFastPosProc;
      CopySize                    : Integer;
      JumpTable                   : TBMJumpTable;
    begin
      LSource := Length(aSourceString);
      if LSource = 0 then begin
        Result := aSourceString;
        exit;
      end;
      PSource := @aSourceString[1];
     
      LFind := Length(aFindString);
      if LFind = 0 then exit;
      PFind := @aFindString[1];
     
      LReplace := Length(aReplaceString);
     
      //Here we may get an Integer Overflow, or OutOfMemory, if so, we use a Delta
      try
        if LReplace <= LFind then
          SetLength(Result,lSource)
        else
          SetLength(Result, (LSource *LReplace) div  LFind);
      except
        SetLength(Result,0);
      end;
     
      LResult := Length(Result);
      if LResult = 0 then begin
        LResult := Trunc((LSource + LReplace) * cDeltaSize);
        SetLength(Result, LResult);
      end;
     
     
      PResult := @Result[1];
     
     
      if CaseSensitive then
      begin
        MakeBMTable(PChar(AFindString), lFind, JumpTable);
        Find := BMPos;
      end else
      begin
        MakeBMTableNoCase(PChar(AFindString), lFind, JumpTable);
        Find := BMPosNoCase;
      end;
     
     
      BytesUsed := 0;
      if LReplace > 0 then begin
        PReplace := @aReplaceString[1];
        repeat
          PPosition := Find(PSource,PFind,lSource, lFind, JumpTable);
          if PPosition = nil then break;
     
          CopySize := PPosition - PSource;
          Inc(BytesUsed, CopySize + LReplace);
     
          if BytesUsed >= LResult then begin
            //We have run out of space
            CurrentPos := Integer(PResult) - Integer(@Result[1]) +1;
            LResult := Trunc(LResult * cDeltaSize);
            SetLength(Result,LResult);
            PResult := @Result[CurrentPos];
          end;
     
          FastCharMove(PSource^,PResult^,CopySize);
          Dec(lSource,CopySize + LFind);
          Inc(PSource,CopySize + LFind);
          Inc(PResult,CopySize);
     
          FastCharMove(PReplace^,PResult^,LReplace);
          Inc(PResult,LReplace);
     
        until lSource < lFind;
      end else begin
        repeat
          PPosition := Find(PSource,PFind,lSource, lFind, JumpTable);
          if PPosition = nil then break;
     
          CopySize := PPosition - PSource;
          FastCharMove(PSource^,PResult^,CopySize);
          Dec(lSource,CopySize + LFind);
          Inc(PSource,CopySize + LFind);
          Inc(PResult,CopySize);
          Inc(BytesUsed, CopySize);
        until lSource < lFind;
      end;
     
      SetLength(Result, (PResult+LSource) - @Result[1]);
      if LSource > 0 then
        FastCharMove(PSource^, Result[BytesUsed + 1], LSource);
    end;
     
    function FastTagReplace(const SourceString, TagStart, TagEnd: string;
      FastTagReplaceProc: TFastTagReplaceProc; const UserData: Integer): string;
    var
      TagStartPChar: PChar;
      TagEndPChar: PChar;
      SourceStringPChar: PChar;
      TagStartFindPos: PChar;
      TagEndFindPos: PChar;
      TagStartLength: Integer;
      TagEndLength: Integer;
      DestPChar: PChar;
      FinalSourceMarkerStart: PChar;
      FinalSourceMarkerEnd: PChar;
      BytesWritten: Integer;
      BufferSize: Integer;
      CopySize: Integer;
      ReplaceString: string;
     
      procedure AddBuffer(const Buffer: Pointer; Size: Integer);
      begin
        if BytesWritten + Size > BufferSize then
        begin
          BufferSize := Trunc(BufferSize * cDeltaSize);
          if BufferSize <= (BytesWritten + Size) then
            BufferSize := Trunc((BytesWritten + Size) * cDeltaSize);
          SetLength(Result, BufferSize);
          DestPChar := @Result[BytesWritten + 1];
        end;
        Inc(BytesWritten, Size);
        FastCharMove(Buffer^, DestPChar^, Size);
        DestPChar := DestPChar + Size;
      end;
     
    begin
      Assert(Assigned(@FastTagReplaceProc));
      TagStartPChar := PChar(TagStart);
      TagEndPChar := PChar(TagEnd);
      if (SourceString = '') or (TagStart = '') or (TagEnd = '') then
      begin
        Result := SourceString;
        Exit;
      end;
     
      SourceStringPChar := PChar(SourceString);
      TagStartLength := Length(TagStart);
      TagEndLength := Length(TagEnd);
      FinalSourceMarkerEnd := SourceStringPChar + Length(SourceString) - TagEndLength;
      FinalSourceMarkerStart := FinalSourceMarkerEnd - TagStartLength;
     
      BytesWritten := 0;
      BufferSize := Length(SourceString);
      SetLength(Result, BufferSize);
      DestPChar := @Result[1];
     
      repeat
        TagStartFindPos := AnsiStrPos(SourceStringPChar, TagStartPChar);
        if (TagStartFindPos = nil) or (TagStartFindPos > FinalSourceMarkerStart) then Break;
        TagEndFindPos := AnsiStrPos(TagStartFindPos + TagStartLength, TagEndPChar);
        if (TagEndFindPos = nil) or (TagEndFindPos > FinalSourceMarkerEnd) then Break;
        CopySize := TagStartFindPos - SourceStringPChar;
        AddBuffer(SourceStringPChar, CopySize);
        CopySize := TagEndFindPos - (TagStartFindPos + TagStartLength);
        SetLength(ReplaceString, CopySize);
        if CopySize > 0 then
          Move((TagStartFindPos + TagStartLength)^, ReplaceString[1], CopySize);
        FastTagReplaceProc(ReplaceString, UserData);
        if Length(ReplaceString) > 0 then
          AddBuffer(@ReplaceString[1], Length(ReplaceString));
        SourceStringPChar := TagEndFindPos + TagEndLength;
      until SourceStringPChar > FinalSourceMarkerStart;
      CopySize := PChar(@SourceString[Length(SourceString)]) - (SourceStringPChar - 1);
      if CopySize > 0 then
        AddBuffer(SourceStringPChar, CopySize);
      SetLength(Result, BytesWritten);
    end;
     
    function SmartPos(const SearchStr,SourceStr : string;
                      const CaseSensitive : Boolean = TRUE;
                      const StartPos : Integer = 1;
                      const ForwardSearch : Boolean = TRUE) : Integer;
    begin
      // NOTE:  When using StartPos, the returned value is absolute!
      if (CaseSensitive) then
        if (ForwardSearch) then
          Result:=
            FastPos(SourceStr,SearchStr,Length(SourceStr),Length(SearchStr),StartPos)
        else
          Result:=
            FastPosBack(SourceStr,SearchStr,Length(SourceStr),Length(SearchStr),StartPos)
      else
        if (ForwardSearch) then
          Result:=
            FastPosNoCase(SourceStr,SearchStr,Length(SourceStr),Length(SearchStr),StartPos)
        else
          Result:=
            FastPosBackNoCase(SourceStr,SearchStr,Length(SourceStr),Length(SearchStr),StartPos)
    end;
     
    var
      I: Integer;
    initialization
      {$IFNDEF LINUX}
        for I:=0 to 255 do GUpcaseTable[I] := Chr(I);
        CharUpperBuff(@GUpcaseTable[0], 256);
      {$ELSE}
        for I:=0 to 255 do GUpcaseTable[I] := UpCase(Chr(I));
      {$ENDIF}
      GUpcaseLUT := @GUpcaseTable[0];
    end.
     
    FastStringFuncs.pas
     
     
    //==================================================
    //All code herein is copyrighted by
    //Peter Morris
    //-----
    //Do not alter / remove this copyright notice
    //Email me at : support@droopyeyes.com
    //
    //The homepage for this library is http://www.droopyeyes.com
    //
    //(Check out www.HowToDoThings.com for Delphi articles !)
    //(Check out www.stuckindoors.com if you need a free events page on your site !)
     
    unit FastStringFuncs;
     
    interface
     
    uses
      {$IFDEF LINUX}
        QGraphics,
      {$ELSE}
        Graphics,
      {$ENDIF}
      FastStrings, Sysutils, Classes;
     
    const
      cHexChars = '0123456789ABCDEF';
      cSoundexTable: array[65..122] of Byte =
        ({A}0, {B}1, {C}2, {D}3, {E}0, {F}1, {G}2, {H}0, {I}0, {J}2, {K}2, {L}4, {M}5,
         {N}5, {O}0, {P}1, {Q}2, {R}6, {S}2, {T}3, {U}0, {V}1, {W}0, {X}2, {Y}0, {Z}2,
         0, 0, 0, 0, 0, 0,
         {a}0, {b}1, {c}2, {d}3, {e}0, {f}1, {g}2, {h}0, {i}0, {j}2, {k}2, {l}4, {m}5,
         {n}5, {o}0, {p}1, {q}2, {r}6, {s}2, {t}3, {u}0, {v}1, {w}0, {x}2, {y}0, {z}2);
     
     
    function Base64Encode(const Source: AnsiString): AnsiString;
    function Base64Decode(const Source: string): string;
    function CopyStr(const aSourceString : string; aStart, aLength : Integer) : string;
    function Decrypt(const S: string; Key: Word): string;
    function Encrypt(const S: string; Key: Word): string;
    function ExtractHTML(S : string) : string;
    function ExtractNonHTML(S : string) : string;
    function HexToInt(aHex : string) : int64;
    function LeftStr(const aSourceString : string; Size : Integer) : string;
    function StringMatches(Value, Pattern : string) : Boolean;
    function MissingText(Pattern, Source : string; SearchText : string = '?') : string;
    function RandomFileName(aFilename : string) : string;
    function RandomStr(aLength : Longint) : string;
    function ReverseStr(const aSourceString: string): string;
    function RightStr(const aSourceString : string; Size : Integer) : string;
    function RGBToColor(aRGB : string) : TColor;
    function StringCount(const aSourceString, aFindString : string; Const CaseSensitive : Boolean = TRUE) : Integer;
    function SoundEx(const aSourceString: string): Integer;
    function UniqueFilename(aFilename : string) : string;
    function URLToText(aValue : string) : string;
    function WordAt(Text : string; Position : Integer) : string;
     
    procedure Split(aValue : string; aDelimiter : Char; var Result : TStrings);
     
    implementation
    const
      cKey1 = 52845;
      cKey2 = 22719;
      Base64_Table : shortstring = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
     
    function StripHTMLorNonHTML(const S : string; WantHTML : Boolean) : string; forward;
     
    //Encode to Base64
    function Base64Encode(const Source: AnsiString): AnsiString;
    var
      NewLength: Integer;
    begin
      NewLength := ((2 + Length(Source)) div 3) * 4;
      SetLength( Result, NewLength);
     
      asm
        Push  ESI
        Push  EDI
        Push  EBX
        Lea   EBX, Base64_Table
        Inc   EBX                // Move past String Size (ShortString)
        Mov   EDI, Result
        Mov   EDI, [EDI]
        Mov   ESI, Source
        Mov   EDX, [ESI-4]        //Length of Input String
    @WriteFirst2:
        CMP EDX, 0
        JLE @Done
        MOV AL, [ESI]
        SHR AL, 2
    {$IFDEF VER140} // Changes to BASM in D6
        XLATB
    {$ELSE}
        XLAT
    {$ENDIF}
        MOV [EDI], AL
        INC EDI
        MOV AL, [ESI + 1]
        MOV AH, [ESI]
        SHR AX, 4
        AND AL, 63
    {$IFDEF VER140} // Changes to BASM in D6
        XLATB
    {$ELSE}
        XLAT
    {$ENDIF}
        MOV [EDI], AL
        INC EDI
        CMP EDX, 1
        JNE @Write3
        MOV AL, 61                        // Add ==
        MOV [EDI], AL
        INC EDI
        MOV [EDI], AL
        INC EDI
        JMP @Done
    @Write3:
        MOV AL, [ESI + 2]
        MOV AH, [ESI + 1]
        SHR AX, 6
        AND AL, 63
    {$IFDEF VER140} // Changes to BASM in D6
        XLATB
    {$ELSE}
        XLAT
    {$ENDIF}
        MOV [EDI], AL
        INC EDI
        CMP EDX, 2
        JNE @Write4
        MOV AL, 61                        // Add =
        MOV [EDI], AL
        INC EDI
        JMP @Done
    @Write4:
        MOV AL, [ESI + 2]
        AND AL, 63
    {$IFDEF VER140} // Changes to BASM in D6
        XLATB
    {$ELSE}
        XLAT
    {$ENDIF}
        MOV [EDI], AL
        INC EDI
        ADD ESI, 3
        SUB EDX, 3
        JMP @WriteFirst2
    @done:
        Pop EBX
        Pop EDI
        Pop ESI
      end;
    end;
     
     
    //Decode Base64
    function Base64Decode(const Source: string): string;
    var
      NewLength: Integer;
    begin
    {
      NB: On invalid input this routine will simply skip the bad data, a
    better solution would probably report the error
     
     
      ESI -> Source String
      EDI -> Result String
     
      ECX -> length of Source (number of DWords)
      EAX -> 32 Bits from Source
      EDX -> 24 Bits Decoded
     
      BL -> Current number of bytes decoded
    }
     
      SetLength( Result, (Length(Source) div 4) * 3);
      NewLength := 0;
      asm
        Push  ESI         
        Push  EDI
        Push  EBX
     
        Mov   ESI, Source
     
        Mov   EDI, Result //Result address
        Mov   EDI, [EDI]
     
        Or    ESI,ESI   // Nil Strings
        Jz    @Done
     
        Mov   ECX, [ESI-4]
        Shr   ECX,2       // DWord Count
     
        JeCxZ @Error      // Empty String
     
        Cld
     
        jmp   @Read4
     
      @Next:
        Dec   ECX
        Jz   @Done
     
      @Read4:
        lodsd
     
        Xor   BL, BL
        Xor   EDX, EDX
     
        Call  @DecodeTo6Bits
        Shl   EDX, 6
        Shr   EAX,8
        Call  @DecodeTo6Bits
        Shl   EDX, 6
        Shr   EAX,8
        Call  @DecodeTo6Bits
        Shl   EDX, 6
        Shr   EAX,8
        Call  @DecodeTo6Bits
     
     
      // Write Word
     
        Or    BL, BL
        JZ    @Next  // No Data
     
        Dec   BL
        Or    BL, BL
        JZ    @Next  // Minimum of 2 decode values to translate to 1 byte
     
        Mov   EAX, EDX
     
        Cmp   BL, 2
        JL    @WriteByte
     
        Rol   EAX, 8
     
        BSWAP EAX
     
        StoSW
     
        Add NewLength, 2
     
      @WriteByte:
        Cmp BL, 2
        JE  @Next
        SHR EAX, 16
        StoSB
     
        Inc NewLength
        jmp   @Next
     
      @Error:
        jmp @Done
     
      @DecodeTo6Bits:
     
      @TestLower:
        Cmp AL, 'a'
        Jl @TestCaps
        Cmp AL, 'z'
        Jg @Skip
        Sub AL, 71
        Jmp @Finish
     
      @TestCaps:
        Cmp AL, 'A'
        Jl  @TestEqual
        Cmp AL, 'Z'
        Jg  @Skip
        Sub AL, 65
        Jmp @Finish
     
      @TestEqual:
        Cmp AL, '='
        Jne @TestNum
        // Skip byte
        ret
     
      @TestNum:
        Cmp AL, '9'
        Jg @Skip
        Cmp AL, '0'
        JL  @TestSlash
        Add AL, 4
        Jmp @Finish
     
      @TestSlash:
        Cmp AL, '/'
        Jne @TestPlus
        Mov AL, 63
        Jmp @Finish
     
      @TestPlus:
        Cmp AL, '+'
        Jne @Skip
        Mov AL, 62
     
      @Finish:
        Or  DL, AL
        Inc BL
     
      @Skip:
        Ret
     
      @Done:
        Pop   EBX
        Pop   EDI
        Pop   ESI
     
      end;
     
      SetLength( Result, NewLength); // Trim off the excess
    end;
     
     
    //Encrypt a string
    function Encrypt(const S: string; Key: Word): string;
    var
    I: byte;
    begin
     SetLength(result,length(s));
     for I := 1 to Length(S) do
        begin
            Result[I] := char(byte(S[I]) xor (Key shr 8));
            Key := (byte(Result[I]) + Key) * cKey1 + cKey2;
        end;
    end;
     
    //Return only the HTML of a string
    function ExtractHTML(S : string) : string;
    begin
      Result := StripHTMLorNonHTML(S, True);
    end;
     
    function CopyStr(const aSourceString : string; aStart, aLength : Integer) : string;
    var
      L                           : Integer;
    begin
      L := Length(aSourceString);
      if L=0 then Exit;
      if (aStart < 1) or (aLength < 1) then Exit;
     
      if aStart + (aLength-1) > L then aLength := L - (aStart-1);
     
      if (aStart <1) then exit;
     
      SetLength(Result,aLength);
      FastCharMove(aSourceString[aStart], Result[1], aLength);
    end;
     
    //Take all HTML out of a string
    function ExtractNonHTML(S : string) : string;
    begin
      Result := StripHTMLorNonHTML(S,False);
    end;
     
    //Decrypt a string encoded with Encrypt
    function Decrypt(const S: string; Key: Word): string;
    var
      I: byte;
    begin
     SetLength(result,length(s));
     for I := 1 to Length(S) do
        begin
            Result[I] := char(byte(S[I]) xor (Key shr 8));
            Key := (byte(S[I]) + Key) * cKey1 + cKey2;
        end;
    end;
     
    //Convert a text-HEX value (FF0088 for example) to an integer
    function  HexToInt(aHex : string) : int64;
    var
      Multiplier      : Int64;
      Position        : Byte;
      Value           : Integer;
    begin
      Result := 0;
      Multiplier := 1;
      Position := Length(aHex);
      while Position >0 do begin
        Value := FastCharPosNoCase(cHexChars, aHex[Position], 1)-1;
        if Value = -1 then
          raise Exception.Create('Invalid hex character ' + aHex[Position]);
     
        Result := Result + (Value * Multiplier);
        Multiplier := Multiplier * 16;
        Dec(Position);
      end;
    end;
     
    //Get the left X amount of chars
    function LeftStr(const aSourceString : string; Size : Integer) : string;
    begin
      if Size > Length(aSourceString) then
        Result := aSourceString
      else begin
        SetLength(Result, Size);
        Move(aSourceString[1],Result[1],Size);
      end;
    end;
     
    //Do strings match with wildcards, eg
    //StringMatches('The cat sat on the mat', 'The * sat * the *') = True
    function StringMatches(Value, Pattern : string) : Boolean;
    var
      NextPos,
      Star1,
      Star2       : Integer;
      NextPattern   : string;
    begin
      Star1 := FastCharPos(Pattern,'*',1);
      if Star1 = 0 then
        Result := (Value = Pattern)
      else
      begin
        Result := (Copy(Value,1,Star1-1) = Copy(Pattern,1,Star1-1));
        if Result then
        begin
          if Star1 > 1 then Value := Copy(Value,Star1,Length(Value));
          Pattern := Copy(Pattern,Star1+1,Length(Pattern));
     
          NextPattern := Pattern;
          Star2 := FastCharPos(NextPattern, '*',1);
          if Star2 > 0 then NextPattern := Copy(NextPattern,1,Star2-1);
     
          //pos(NextPattern,Value);
          NextPos := FastPos(Value, NextPattern, Length(Value), Length(NextPattern), 1);
          if (NextPos = 0) and not (NextPattern = '') then
            Result := False
          else
          begin
            Value := Copy(Value,NextPos,Length(Value));
            if Pattern = '' then
              Result := True
            else
              Result := Result and StringMatches(Value,Pattern);
          end;
        end;
      end;
    end;
     
    //Missing text will tell you what text is missing, eg
    //MissingText('the ? sat on the mat','the cat sat on the mat','?') = 'cat'
    function MissingText(Pattern, Source : string; SearchText : string = '?') : string;
    var
      Position                    : Longint;
      BeforeText,
      AfterText                   : string;
      BeforePos,
      AfterPos                     : Integer;
      lSearchText,
      lBeforeText,
      lAfterText,
      lSource                     : Longint;
    begin
      Result := '';
      Position := Pos(SearchText,Pattern);
      if Position = 0 then exit;
     
      lSearchText := Length(SearchText);
      lSource := Length(Source);
      BeforeText := Copy(Pattern,1,Position-1);
      AfterText := Copy(Pattern,Position+lSearchText,lSource);
     
      lBeforeText := Length(BeforeText);
      lAfterText := Length(AfterText);
     
      AfterPos := lBeforeText;
      repeat
        AfterPos := FastPosNoCase(Source,AfterText,lSource,lAfterText,AfterPos+lSearchText);
        if AfterPos > 0 then begin
          BeforePos := FastPosBackNoCase(Source,BeforeText,AfterPos-1,lBeforeText,AfterPos - (lBeforeText-1));
          if (BeforePos > 0) then begin
            Result := Copy(Source,BeforePos + lBeforeText, AfterPos - (BeforePos + lBeforeText));
            Break;
          end;
        end;
      until AfterPos = 0;
    end;
     
    //Generates a random filename but preserves the original path + extension
    function RandomFilename(aFilename : string) : string;
    var
      Path,
      Filename,
      Ext               : string;
    begin
      Result := aFilename;
      Path := ExtractFilepath(aFilename);
      Ext := ExtractFileExt(aFilename);
      Filename := ExtractFilename(aFilename);
      if Length(Ext) > 0 then
        Filename := Copy(Filename,1,Length(Filename)-Length(Ext));
      repeat
        Result := Path + RandomStr(32) + Ext;
      until not FileExists(Result);
    end;
     
    //Makes a string of aLength filled with random characters
    function RandomStr(aLength : Longint) : string;
    var
      X                           : Longint;
    begin
      if aLength <= 0 then exit;
      SetLength(Result, aLength);
      for X:=1 to aLength do
        Result[X] := Chr(Random(26) + 65);
    end;
     
    function ReverseStr(const aSourceString: string): string;
    var
      L                           : Integer;
      S,
      D                           : Pointer;
    begin
      L := Length(aSourceString);
      SetLength(Result,L);
      if L = 0 then exit;
     
      S := @aSourceString[1];
      D := @Result[L];
     
      asm
        push ESI
        push EDI
     
        mov  ECX, L
        mov  ESI, S
        mov  EDI, D
     
      @Loop:
        mov  Al, [ESI]
        inc  ESI
        mov  [EDI], Al
        dec  EDI
        dec  ECX
        jnz  @Loop
     
        pop  EDI
        pop  ESI
      end;
    end;
     
    //Returns X amount of chars from the right of a string
    function RightStr(const aSourceString : string; Size : Integer) : string;
    begin
      if Size > Length(aSourceString) then
        Result := aSourceString
      else begin
        SetLength(Result, Size);
        FastCharMove(aSourceString[Length(aSourceString)-(Size-1)],Result[1],Size);
      end;
    end;
     
    //Converts a typical HTML RRGGBB color to a TColor
    function RGBToColor(aRGB : string) : TColor;
    begin
      if Length(aRGB) < 6 then raise EConvertError.Create('Not a valid RGB value');
      if aRGB[1] = '#' then aRGB := Copy(aRGB,2,Length(aRGB));
      if Length(aRGB) <> 6 then raise EConvertError.Create('Not a valid RGB value');
     
      Result := HexToInt(aRGB);
      asm
        mov   EAX, Result
        BSwap EAX
        shr   EAX, 8
        mov   Result, EAX
      end;
    end;
     
    //Splits a delimited text line into TStrings (does not account for stuff in quotes but it should)
    procedure Split(aValue : string; aDelimiter : Char; var Result : TStrings);
    var
      X : Integer;
      S : string;
    begin
      if Result = nil then Result := TStringList.Create;
      Result.Clear;
      S := '';
      for X:=1 to Length(aValue) do begin
        if aValue[X] <> aDelimiter then
          S:=S + aValue[X]
        else begin
          Result.Add(S);
          S := '';
        end;
      end;
      if S <> '' then Result.Add(S);
    end;
     
    //counts how many times a substring exists within a string
    //StringCount('XXXXX','XX') would return 2
    function StringCount(const aSourceString, aFindString : string; Const CaseSensitive : Boolean = TRUE) : Integer;
    var
      Find,
      Source,
      NextPos                     : PChar;
      LSource,
      LFind                       : Integer;
      Next                        : TFastPosProc;
      JumpTable                   : TBMJumpTable;
    begin
      Result := 0;
      LSource := Length(aSourceString);
      if LSource = 0 then exit;
     
      LFind := Length(aFindString);
      if LFind = 0 then exit;
     
      if CaseSensitive then
      begin
        Next := BMPos;
        MakeBMTable(PChar(aFindString), Length(aFindString), JumpTable);
      end else
      begin
        Next := BMPosNoCase;
        MakeBMTableNoCase(PChar(aFindString), Length(aFindString), JumpTable);
      end;
     
      Source := @aSourceString[1];
      Find := @aFindString[1];
     
      repeat
        NextPos := Next(Source, Find, LSource, LFind, JumpTable);
        if NextPos <> nil then
        begin
          Dec(LSource, (NextPos - Source) + LFind);
          Inc(Result);
          Source := NextPos + LFind;
        end;
      until NextPos = nil;
    end;
     
    function SoundEx(const aSourceString: string): Integer;
    var
      CurrentChar: PChar;
      I, S, LastChar, SoundexGroup: Byte;
      Multiple: Word;
    begin
      if aSourceString = '' then
        Result := 0
      else
      begin
        //Store first letter immediately
        Result := Ord(Upcase(aSourceString[1]));
     
        //Last character found = 0
        LastChar := 0;
        Multiple := 26;
     
        //Point to first character
        CurrentChar := @aSourceString[1];
     
        for I := 1 to Length(aSourceString) do
        begin
          Inc(CurrentChar);
     
          S := Ord(CurrentChar^);
          if (S > 64) and (S < 123) then
          begin
            SoundexGroup := cSoundexTable[S];
            if (SoundexGroup <> LastChar) and (SoundexGroup > 0) then
            begin
              Inc(Result, SoundexGroup * Multiple);
              if Multiple = 936 then Break; {26 * 6 * 6}
              Multiple := Multiple * 6;
              LastChar := SoundexGroup;
            end;
          end;
        end;
      end;
    end;
     
    //Used by ExtractHTML and ExtractNonHTML
    function StripHTMLorNonHTML(const S : string; WantHTML : Boolean) : string;
    var
      X: Integer;
      TagCnt: Integer;
      ResChar: PChar;
      SrcChar: PChar;
    begin
      TagCnt := 0;
      SetLength(Result, Length(S));
      if Length(S) = 0 then Exit;
     
      ResChar := @Result[1];
      SrcChar := @S[1];
      for X:=1 to Length(S) do
      begin
        case SrcChar^ of
          '<':
            begin
              Inc(TagCnt);
              if WantHTML and (TagCnt = 1) then
              begin
                ResChar^ := '<';
                Inc(ResChar);
              end;
            end;
          '>':
            begin
              Dec(TagCnt);
              if WantHTML and (TagCnt = 0) then
              begin
                ResChar^ := '>';
                Inc(ResChar);
              end;
            end;
        else
          case WantHTML of
            False:
              if TagCnt <= 0 then
              begin
                ResChar^ := SrcChar^;
                Inc(ResChar);
                TagCnt := 0;
              end;
            True:
              if TagCnt >= 1 then
              begin
                ResChar^ := SrcChar^;
                Inc(ResChar);
              end else
                if TagCnt < 0 then TagCnt := 0;
          end;
        end;
        Inc(SrcChar);
      end;
      SetLength(Result, ResChar - PChar(@Result[1]));
      Result := FastReplace(Result, '&nbsp;', ' ', False);
      Result := FastReplace(Result,'&amp;','&', False);
      Result := FastReplace(Result,'&lt;','<', False);
      Result := FastReplace(Result,'&gt;','>', False);
      Result := FastReplace(Result,'&quot;','"', False);
    end;
     
    //Generates a UniqueFilename, makes sure the file does not exist before returning a result
    function UniqueFilename(aFilename : string) : string;
    var
      Path,
      Filename,
      Ext               : string;
      Index             : Integer;
    begin
      Result := aFilename;
      if FileExists(aFilename) then begin
        Path := ExtractFilepath(aFilename);
        Ext := ExtractFileExt(aFilename);
        Filename := ExtractFilename(aFilename);
        if Length(Ext) > 0 then
          Filename := Copy(Filename,1,Length(Filename)-Length(Ext));
        Index := 2;
        repeat
          Result := Path + Filename + IntToStr(Index) + Ext;
          Inc(Index);
        until not FileExists(Result);
      end;
    end;
     
    //Decodes all that %3c stuff you get in a URL
    function  URLToText(aValue : string) : string;
    var
      X     : Integer;
    begin
      Result := '';
      X := 1;
      while X <= Length(aValue) do begin
        if aValue[X] <> '%' then
          Result := Result + aValue[X]
        else begin
          Result := Result + Chr( HexToInt( Copy(aValue,X+1,2) ) );
          Inc(X,2);
        end;
        Inc(X);
      end;
    end;
     
    //Returns the whole word at a position
    function  WordAt(Text : string; Position : Integer) : string;
    var
      L,
      X : Integer;
    begin
      Result := '';
      L := Length(Text);
     
      if (Position > L) or (Position < 1) then Exit; 
      for X:=Position to L do begin
        if Upcase(Text[X]) in ['A'..'Z','0'..'9'] then
          Result := Result + Text[X]
        else
          Break;
      end;
     
      for X:=Position-1 downto 1 do begin
        if Upcase(Text[X]) in ['A'..'Z','0'..'9'] then
          Result := Text[X] + Result
        else
          Break;
      end;
    end;
     
     
    end.

