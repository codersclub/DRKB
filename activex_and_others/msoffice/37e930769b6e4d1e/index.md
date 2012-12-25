---
Title: Проверка правописания и синонимов при помощи компонентов Microsoft Office
Date: 01.01.2007
---


Проверка правописания и синонимов при помощи компонентов Microsoft Office
=========================================================================

::: {.date}
01.01.2007
:::

This is the VCL for Spell Checking and Synonyms using MS Word COM
interface. It can correct and replace words in a Text String,TMemo or
TRichEdit using a built in replacement editor, or can be controlled by
user dialog. I see there are other callable functions in the interface,
which I have not implemented. Anyone see a use for any of them ?.

They are ...

        property PartOfSpeechList: OleVariant  read Get_PartOfSpeechList; 
        property AntonymList: OleVariant read Get_AntonymList; 
        property RelatedExpressionList: OleVariant  read Get_RelatedExpressionList; 
        property RelatedWordList: OleVariant  read Get_RelatedWordList; 

Example of checking and changing a Memo text ...

  SpellCheck.CheckMemoTextSpelling(Memo1);

Properties

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

LetterChars           - Characters considered to be letters. default
is  

                                  \[\'A\'..\'Z\',\'a\'..\'z\'\]
(English) but could be changed to

                                 
\[\'A\'..\'Z\',\'a\'..\'z\',\'б\',\'й\',\'н\',\'у\',\'ъ\'\] (Spanish)

Color                       - Backgound color of Default dialog Editbox
and Listbox

CompletedMessage - Enable/Disable display of completed and count message
dialog

Font                         - Font of Default dialog Editbox and
Listbox

Language                - Language used by GetSynonyms() method

ReplaceDialog         - Use Default replace dialog or User defined  (see
events)

Active                      - Readonly, set at create time. Indicates if
MS Word is  available

Methods

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

function GetSynonyms(StrWord : string; Synonyms : TStrings) : boolean;

        True if synonyms found for StrWord. Synonyms List is  

        returned in TStrings (Synonyms).

function CheckWordSpelling(StrWord : string; Suggestions : TStrings) :
boolean;

        True if StrWord is spelt correctly. Suggested corrections

        returned in TStrings (Suggestions)

procedure CheckTextSpelling(var StrText : string);

         Proccesses string StrText and allows users to change  

         mispelt  words via a Default replacement dialog or User  

         defined calls. Words are changed and returned in StrText.

         Words in the text are changed automatically by the Default

         editor. Use the  events if you want to control the dialog

         yourself. ie. Get the mispelt word, give a choice of

         sugesstions (BeforeCorrection), Change the word to

         corrected  (OnCorrection) and possibly display \"Was/Now\"

         (AfterCorrection)

procedure CheckRichTextSpelling(RichEdit : TRichEdit);

        Corrects misspelt words directly in TRichEdit.Text.

        Rich Format is maintained.

procedure CheckMemoTextSpelling(Memo : TMemo);

        Corrects misspelt words directly into a TMemo.Text.

Events (Mainly used when ReplaceDialog = repUser)

\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\--

BeforeCorrection - Supplies the mispelt word along with a TStrings

                                var containing suggested corrections.

OnCorrection       - Supplies the mispelt word as a VAR type allowing

                               user to change it to desired word. The
word will be

                               replaced by this variable in the passed
StrText.

AfterCorrection - Supplies the mispelt word and what it has been

                              changed to.

    unit SpellChk;
    interface
     
    // =============================================================================
    // MS Word COM Interface to Spell Check and Synonyms
    // Mike Heydon Dec 2000
    // mheydon@pgbison.co.za
    // =============================================================================
     
    uses Windows, SysUtils, Classes, ComObj, Dialogs, Forms, StdCtrls,
      Controls, Buttons, Graphics, ComCtrls, Variants;
     
    // Above uses Variants is for Delphi 6 - remove for Delphi 5 and less
     
    type
      // Event definitions
      TSpellCheckBeforeCorrection = procedure(Sender: TObject;
        MispeltWord: string;
        Suggestions: TStrings) of object;
     
      TSpellCheckAfterCorrection = procedure(Sender: TObject;
        MispeltWord: string;
        CorrectedWord: string) of object;
     
      TSpellCheckOnCorrection = procedure(Sender: TObject;
        var WordToCorrect: string) of object;
     
      // Property types
      TSpellCheckReplacement = (repDefault, repUser);
      TSpellCheckLetters = set of char;
     
      TSpellCheckLanguage = (wdLanguageNone, wdNoProofing, wdDanish, wdGerman,
        wdSwissGerman, wdEnglishAUS, wdEnglishUK, wdEnglishUS,
        wdEnglishCanadian, wdEnglishNewZealand,
        wdEnglishSouthAfrica, wdSpanish, wdFrench,
        wdFrenchCanadian, wdItalian, wdDutch, wdNorwegianBokmol,
        wdNorwegianNynorsk, wdBrazilianPortuguese,
        wdPortuguese, wdFinnish, wdSwedish, wdCatalan, wdGreek,
        wdTurkish, wdRussian, wdCzech, wdHungarian, wdPolish,
        wdSlovenian, wdBasque, wdMalaysian, wdJapanese, wdKorean,
        wdSimplifiedChinese, wdTraditionalChinese,
        wdSwissFrench, wdSesotho, wdTsonga, wdTswana, wdVenda,
        wdXhosa, wdZulu, wdAfrikaans, wdArabic, wdHebrew,
        wdSlovak, wdFarsi, wdRomanian, wdCroatian, wdUkrainian,
        wdByelorussian, wdEstonian, wdLatvian, wdMacedonian,
        wdSerbianLatin, wdSerbianCyrillic, wdIcelandic,
        wdBelgianFrench, wdBelgianDutch, wdBulgarian,
        wdMexicanSpanish, wdSpanishModernSort, wdSwissItalian);
     
      // Main TSpellcheck Class
      TSpellCheck = class(TComponent)
      private
        MsWordApp,
          MsSuggestions: OleVariant;
        FLetterChars: TSpellCheckLetters;
        FFont: TFont;
        FColor: TColor;
        FReplaceDialog: TSpellCheckReplacement;
        FCompletedMessage,
          FActive: boolean;
        FLanguage: TSpellCheckLanguage;
        FForm: TForm;
        FEbox: TEdit;
        FLbox: TListBox;
        FCancelBtn,
          FChangeBtn: TBitBtn;
        FBeforeCorrection: TSpellCheckBeforeCorrection;
        FAfterCorrection: TSpellCheckAfterCorrection;
        FOnCorrection: TSpellCheckOnCorrection;
        procedure SetFFont(NewValue: TFont);
      protected
        procedure MakeForm;
        procedure CloseForm;
        procedure SuggestedClick(Sender: TObject);
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        function GetSynonyms(StrWord: string; Synonyms: TStrings): boolean;
        function CheckWordSpelling(StrWord: string;
          Suggestions: TStrings): boolean;
        procedure CheckTextSpelling(var StrText: string);
        procedure CheckRichTextSpelling(RichEdit: TRichEdit);
        procedure CheckMemoTextSpelling(Memo: TMemo);
        procedure Anagrams(const InString: string; StringList: TStrings);
        property Active: boolean read FActive;
        property LetterChars: TSpellCheckletters read FLetterChars write FLetterChars;
      published
        property Language: TSpellCheckLanguage read FLanguage
          write FLanguage;
        property CompletedMessage: boolean read FCompletedMessage
          write FCompletedMessage;
        property Color: TColor read FColor write FColor;
        property Font: TFont read FFont write SetFFont;
        property BeforeCorrection: TSpellCheckBeforeCorrection
          read FBeforeCorrection
          write FBeforeCorrection;
        property AfterCorrection: TSpellCheckAfterCorrection
          read FAfterCorrection
          write FAfterCorrection;
        property OnCorrection: TSpellCheckOnCorrection
          read FOnCorrection
          write FOnCorrection;
        property ReplaceDialog: TSpellCheckReplacement
          read FReplaceDialog
          write FReplaceDialog;
      end;
     
    procedure Register;
     
    // -----------------------------------------------------------------------------
    implementation
     
    // Mapped Hex values for ord(FLanguage)
    const
     
      LanguageArray: array[0..63] of integer =
      ($0, $400, $406, $407, $807, $C09, $809, $409,
        $1009, $1409, $1C09, $40A, $40C, $C0C, $410,
        $413, $414, $814, $416, $816, $40B, $41D, $403,
        $408, $41F, $419, $405, $40E, $415, $424, $42D,
        $43E, $411, $412, $804, $404, $100C, $430, $431,
        $432, $433, $434, $435, $436, $401, $40D, $41B,
        $429, $418, $41A, $422, $423, $425, $426, $42F,
        $81A, $C1A, $40F, $80C, $813, $402, $80A, $C0A, $810);
     
      // Change to Component Pallete of choice
     
    procedure Register;
    begin
      RegisterComponents('MahExtra', [TSpellCheck]);
    end;
     
    // TSpellCheck
     
    constructor TSpellCheck.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      // Defaults
      FLetterChars := ['A'..'Z', 'a'..'z'];
      FCompletedMessage := true;
      FColor := clWindow;
      FFont := TFont.Create;
      FReplaceDialog := repDefault;
      FLanguage := wdEnglishUS;
     
      // Don't create an ole server at design time
      if not (csDesigning in ComponentState) then
      begin
        try
          MsWordApp := CreateOleObject('Word.Application');
          FActive := true;
          MsWordApp.Documents.Add;
        except
          on E: Exception do
          begin
            // MessageDlg('Cannot Connect to MS Word',mtError,[mbOk],0);
            // Activate above if visual failure required
            FActive := false;
          end;
        end;
      end;
    end;
     
    destructor TSpellCheck.Destroy;
    begin
      FFont.Free;
     
      if FActive and not (csDesigning in ComponentState) then
      begin
        MsWordApp.Quit;
        MsWordApp := VarNull;
      end;
     
      inherited Destroy;
    end;
     
    // ======================================
    // Property Get/Set methods
    // ======================================
     
    procedure TSpellCheck.SetFFont(NewValue: TFont);
    begin
      FFont.Assign(NewValue);
    end;
     
    // ===========================================
    // Return a list of synonyms for single word
    // ===========================================
     
    function TSpellCheck.GetSynonyms(StrWord: string;
      Synonyms: TStrings): boolean;
    var
      SynInfo: OleVariant;
      i, j: integer;
      TS: OleVariant;
      Retvar: boolean;
    begin
      Synonyms.Clear;
     
      if FActive then
      begin
        SynInfo := MsWordApp.SynonymInfo[StrWord,
          LanguageArray[ord(FLanguage)]];
        for i := 1 to SynInfo.MeaningCount do
        begin
          TS := SynInfo.SynonymList[i];
          for j := VarArrayLowBound(TS, 1) to VarArrayHighBound(TS, 1) do
            Synonyms.Add(TS[j]);
        end;
     
        RetVar := SynInfo.Found;
      end
      else
        RetVar := false;
     
      Result := RetVar;
    end;
     
    // =======================================
    // Check the spelling of a single word
    // Suggestions returned in TStrings
    // =======================================
     
    function TSpellCheck.CheckWordSpelling(StrWord: string;
      Suggestions: TStrings): boolean;
    var
      Retvar: boolean;
      i: integer;
    begin
      RetVar := false;
      if Suggestions <> nil then
        Suggestions.Clear;
     
      if FActive then
      begin
        if MsWordApp.CheckSpelling(StrWord) then
          RetVar := true
        else
        begin
          if Suggestions <> nil then
          begin
            MsSuggestions := MsWordApp.GetSpellingSuggestions(StrWord);
            for i := 1 to MsSuggestions.Count do
              Suggestions.Add(MsSuggestions.Item(i));
            MsSuggestions := VarNull;
          end;
        end;
      end;
     
      Result := RetVar;
    end;
     
    // ======================================================
    // Check the spelling text of a string with option to
    // Replace words. Correct string returned in var StrText
    // ======================================================
     
    procedure TSpellCheck.CheckTextSpelling(var StrText: string);
    var
      StartPos, CurPos,
        WordsChanged: integer;
      ChkWord, UserWord: string;
      EoTxt: boolean;
     
      procedure GetNextWordStart;
      begin
        ChkWord := '';
        while (StartPos <= length(StrText)) and
          (not (StrText[StartPos] in FLetterChars)) do
          inc(StartPos);
        CurPos := StartPos;
      end;
     
    begin
      if FActive and (length(StrText) > 0) then
      begin
        MakeForm;
        StartPos := 1;
        EoTxt := false;
        WordsChanged := 0;
        GetNextWordStart;
     
        while not EoTxt do
        begin
          // Is it a letter ?
          if StrText[CurPos] in FLetterChars then
          begin
            ChkWord := ChkWord + StrText[CurPos];
            inc(CurPos);
          end
          else
          begin
            // Word end found - check spelling
            if not CheckWordSpelling(ChkWord, FLbox.Items) then
            begin
              if Assigned(FBeforeCorrection) then
                FBeforeCorrection(self, ChkWord, FLbox.Items);
     
              // Default replacement dialog
              if FReplaceDialog = repDefault then
              begin
                FEbox.Text := ChkWord;
                FForm.ShowModal;
     
                if FForm.ModalResult = mrOk then
                begin
                  // Change mispelt word
                  Delete(StrText, StartPos, length(ChkWord));
                  Insert(FEbox.Text, StrText, StartPos);
                  CurPos := StartPos + length(FEbox.Text);
     
                  if ChkWord <> FEbox.Text then
                  begin
                    inc(WordsChanged);
                    if Assigned(FAfterCorrection) then
                      FAfterCorrection(self, ChkWord, FEbox.Text);
                  end;
                end
              end
              else
              begin
                // User defined replacemnt routine
                UserWord := ChkWord;
                if Assigned(FOnCorrection) then
                  FOnCorrection(self, UserWord);
                Delete(StrText, StartPos, length(ChkWord));
                Insert(UserWord, StrText, StartPos);
                CurPos := StartPos + length(UserWord);
     
                if ChkWord <> UserWord then
                begin
                  inc(WordsChanged);
                  if Assigned(FAfterCorrection) then
                    FAfterCorrection(self, ChkWord, UserWord);
                end;
              end;
            end;
     
            StartPos := CurPos;
            GetNextWordStart;
            EoTxt := (StartPos > length(StrText));
          end;
        end;
     
        CloseForm;
        if FCompletedMessage then
          MessageDlg('Spell Check Complete' + #13#10 +
            IntToStr(WordsChanged) + ' words changed',
            mtInformation, [mbOk], 0);
      end
      else if not FActive then
        MessageDlg('Spell Check not Active', mtError, [mbOk], 0)
      else if FCompletedMessage then
        MessageDlg('Spell Check Complete' + #13#10 +
          '0 words changed', mtInformation, [mbOk], 0);
    end;
     
    // =============================================================
    // Check the spelling of RichText with option to
    // Replace words (in situ replacement direct to RichEdit.Text)
    // =============================================================
     
    procedure TSpellCheck.CheckRichTextSpelling(RichEdit: TRichEdit);
    var
      StartPos, CurPos,
        WordsChanged: integer;
      StrText, ChkWord, UserWord: string;
      SaveHide,
        EoTxt: boolean;
     
      procedure GetNextWordStart;
      begin
        ChkWord := '';
        while (not (StrText[StartPos] in FLetterChars)) and
          (StartPos <= length(StrText)) do
          inc(StartPos);
        CurPos := StartPos;
      end;
     
    begin
      SaveHide := RichEdit.HideSelection;
      RichEdit.HideSelection := false;
      StrText := RichEdit.Text;
      if FActive and (length(StrText) > 0) then
      begin
        MakeForm;
        StartPos := 1;
        EoTxt := false;
        WordsChanged := 0;
        GetNextWordStart;
     
        while not EoTxt do
        begin
          // Is it a letter ?
          if StrText[CurPos] in FLetterChars then
          begin
            ChkWord := ChkWord + StrText[CurPos];
            inc(CurPos);
          end
          else
          begin
            // Word end found - check spelling
            if not CheckWordSpelling(ChkWord, FLbox.Items) then
            begin
              if Assigned(FBeforeCorrection) then
                FBeforeCorrection(self, ChkWord, FLbox.Items);
     
              // Default replacement dialog
              if FReplaceDialog = repDefault then
              begin
                FEbox.Text := ChkWord;
                RichEdit.SelStart := StartPos - 1;
                RichEdit.SelLength := length(ChkWord);
                FForm.ShowModal;
     
                if FForm.ModalResult = mrOk then
                begin
                  // Change mispelt word
                  Delete(StrText, StartPos, length(ChkWord));
                  Insert(FEbox.Text, StrText, StartPos);
                  CurPos := StartPos + length(FEbox.Text);
                  RichEdit.SelText := FEbox.Text;
     
                  if ChkWord <> FEbox.Text then
                  begin
                    inc(WordsChanged);
                    if Assigned(FAfterCorrection) then
                      FAfterCorrection(self, ChkWord, FEbox.Text);
                  end;
                end
              end
              else
              begin
                // User defined replacemnt routine
                UserWord := ChkWord;
                RichEdit.SelStart := StartPos - 1;
                RichEdit.SelLength := length(ChkWord);
                if Assigned(FOnCorrection) then
                  FOnCorrection(self, UserWord);
                Delete(StrText, StartPos, length(ChkWord));
                Insert(UserWord, StrText, StartPos);
                CurPos := StartPos + length(UserWord);
                RichEdit.SelText := UserWord;
     
                if ChkWord <> UserWord then
                begin
                  inc(WordsChanged);
                  if Assigned(FAfterCorrection) then
                    FAfterCorrection(self, ChkWord, UserWord);
                end;
              end;
            end;
     
            StartPos := CurPos;
            GetNextWordStart;
            EoTxt := (StartPos > length(StrText));
          end;
        end;
     
        CloseForm;
        RichEdit.HideSelection := SaveHide;
        if FCompletedMessage then
          MessageDlg('Spell Check Complete' + #13#10 +
            IntToStr(WordsChanged) + ' words changed',
            mtInformation, [mbOk], 0);
      end
      else if not FActive then
        MessageDlg('Spell Check not Active', mtError, [mbOk], 0)
      else if FCompletedMessage then
        MessageDlg('Spell Check Complete' + #13#10 +
          '0 words changed', mtInformation, [mbOk], 0);
    end;
     
    // =============================================================
    // Check the spelling of Memo with option to
    // Replace words (in situ replacement direct to Memo.Text)
    // =============================================================
     
    procedure TSpellCheck.CheckMemoTextSpelling(Memo: TMemo);
    var
      StartPos, CurPos,
        WordsChanged: integer;
      StrText, ChkWord, UserWord: string;
      SaveHide,
        EoTxt: boolean;
     
      procedure GetNextWordStart;
      begin
        ChkWord := '';
        while (not (StrText[StartPos] in FLetterChars)) and
          (StartPos <= length(StrText)) do
          inc(StartPos);
        CurPos := StartPos;
      end;
     
    begin
      SaveHide := Memo.HideSelection;
      Memo.HideSelection := false;
      StrText := Memo.Text;
      if FActive and (length(StrText) > 0) then
      begin
        MakeForm;
        StartPos := 1;
        EoTxt := false;
        WordsChanged := 0;
        GetNextWordStart;
     
        while not EoTxt do
        begin
          // Is it a letter ?
          if StrText[CurPos] in FLetterChars then
          begin
            ChkWord := ChkWord + StrText[CurPos];
            inc(CurPos);
          end
          else
          begin
            // Word end found - check spelling
            if not CheckWordSpelling(ChkWord, FLbox.Items) then
            begin
              if Assigned(FBeforeCorrection) then
                FBeforeCorrection(self, ChkWord, FLbox.Items);
     
              // Default replacement dialog
              if FReplaceDialog = repDefault then
              begin
                FEbox.Text := ChkWord;
                Memo.SelStart := StartPos - 1;
                Memo.SelLength := length(ChkWord);
                FForm.ShowModal;
     
                if FForm.ModalResult = mrOk then
                begin
                  // Change mispelt word
                  Delete(StrText, StartPos, length(ChkWord));
                  Insert(FEbox.Text, StrText, StartPos);
                  CurPos := StartPos + length(FEbox.Text);
                  Memo.SelText := FEbox.Text;
     
                  if ChkWord <> FEbox.Text then
                  begin
                    inc(WordsChanged);
                    if Assigned(FAfterCorrection) then
                      FAfterCorrection(self, ChkWord, FEbox.Text);
                  end;
                end
              end
              else
              begin
                // User defined replacemnt routine
                UserWord := ChkWord;
                Memo.SelStart := StartPos - 1;
                Memo.SelLength := length(ChkWord);
                if Assigned(FOnCorrection) then
                  FOnCorrection(self, UserWord);
                Delete(StrText, StartPos, length(ChkWord));
                Insert(UserWord, StrText, StartPos);
                CurPos := StartPos + length(UserWord);
                Memo.SelText := UserWord;
     
                if ChkWord <> UserWord then
                begin
                  inc(WordsChanged);
                  if Assigned(FAfterCorrection) then
                    FAfterCorrection(self, ChkWord, UserWord);
                end;
              end;
            end;
     
            StartPos := CurPos;
            GetNextWordStart;
            EoTxt := (StartPos > length(StrText));
          end;
        end;
     
        Memo.HideSelection := SaveHide;
        CloseForm;
        if FCompletedMessage then
          MessageDlg('Spell Check Complete' + #13#10 +
            IntToStr(WordsChanged) + ' words changed',
            mtInformation, [mbOk], 0);
      end
      else if not FActive then
        MessageDlg('Spell Check not Active', mtError, [mbOk], 0)
      else if FCompletedMessage then
        MessageDlg('Spell Check Complete' + #13#10 +
          '0 words changed', mtInformation, [mbOk], 0);
    end;
     
    // ======================================================================
    // Return a list of Anagrams - Careful, long words generate HUGE lists
    // ======================================================================
     
    procedure TSpellCheck.Anagrams(const InString: string; StringList: TStrings);
    var
      WordsChecked, WordsFound: integer;
     
      procedure RecursePerm(const StrA, StrB: string; Len: integer; SL: TStrings);
      var
        i: integer;
        A, B: string;
      begin
        if (length(StrA) = Len) then
        begin
          inc(WordsChecked);
          if (SL.IndexOf(StrA) = -1) and MsWordApp.CheckSpelling(StrA) then
          begin
            inc(WordsFound);
            SL.Add(StrA);
            Application.ProcessMessages;
          end;
        end;
     
        for i := 1 to length(StrB) do
        begin
          A := StrB;
          B := StrA + A[i];
          delete(A, i, 1);
          RecursePerm(B, A, Len, SL);
        end;
      end;
     
    begin
      if FActive then
      begin
        WordsChecked := 0;
        WordsFound := 0;
        StringList.Clear;
        Application.ProcessMessages;
        RecursePerm('', LowerCase(InString), length(InString), StringList);
        if FCompletedMessage then
          MessageDlg('Anagram Search Check Complete' + #13#10 +
            IntToStr(WordsChecked) + ' words checked' + #13#10 +
            IntToStr(WordsFound) + ' anagrams found',
            mtInformation, [mbOk], 0);
      end
      else
        MessageDlg('Spell Check not Active', mtError, [mbOk], 0);
    end;
     
    // =========================================
    // Create default replacement form
    // =========================================
     
    procedure TSpellCheck.MakeForm;
    begin
      // Correction form container
      FForm := TForm.Create(nil);
      FForm.Position := poScreenCenter;
      FForm.BorderStyle := bsDialog;
      FForm.Height := 260; // 240 if no caption
      FForm.Width := 210;
     
      // Remove form's caption if desired
      //  SetWindowLong(FForm.Handle,GWL_STYLE,
      //                GetWindowLong(FForm.Handle,GWL_STYLE) AND NOT WS_CAPTION);
     
      FForm.ClientHeight := FForm.Height;
     
      // Edit box of offending word
      FEbox := TEdit.Create(FForm);
      FEbox.Parent := FForm;
      FEbox.Top := 8;
      FEbox.Left := 8;
      FEbox.Width := 185;
      FEBox.Font := FFont;
      FEbox.Color := FColor;
     
      // Suggestion list box
      FLbox := TListBox.Create(FForm);
      FLbox.Parent := FForm;
      FLbox.Top := 32;
      FLbox.Left := 8;
      FLbox.Width := 185;
      FLbox.Height := 193;
      FLbox.Color := FColor;
      FLbox.Font := FFont;
      FLbox.OnClick := SuggestedClick;
      FLbox.OnDblClick := SuggestedClick;
     
      // Cancel Button
      FCancelBtn := TBitBtn.Create(FForm);
      FCancelBtn.Parent := FForm;
      FCancelBtn.Top := 232;
      FCancelBtn.Left := 8;
      FCancelBtn.Kind := bkCancel;
      FCancelBtn.Caption := 'Ignore';
     
      // Change Button
      FChangeBtn := TBitBtn.Create(FForm);
      FChangeBtn.Parent := FForm;
      FChangeBtn.Top := 232;
      FChangeBtn.Left := 120;
      FChangeBtn.Kind := bkOk;
      FChangeBtn.Caption := 'Change';
    end;
     
    // =============================================
    // Close the correction form and free memory
    // =============================================
     
    procedure TSpellCheck.CloseForm;
    begin
      FChangeBtn.Free;
      FCancelBtn.Free;
      FLbox.Free;
      FEbox.Free;
      FForm.Free;
    end;
     
    // ====================================================
    // FLbox on click event to populate the edit box
    // with selected suggestion (OnClick/OnDblClick)
    // ====================================================
     
    procedure TSpellCheck.SuggestedClick(Sender: TObject);
    begin
      FEbox.Text := FLbox.Items[FLbox.ItemIndex];
    end;
     
    end.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
