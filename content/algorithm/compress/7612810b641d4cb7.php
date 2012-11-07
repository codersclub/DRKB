<h1>Алгоритм уплотнения данных по методу Хафмана</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{$A+,B-,D+,E+,F-,G-,I-,L+,N-,O-,R+,S+,V+,X-}
{$M 16384,0,655360}
{******************************************************}
{*         Алгоритм уплотнения данных по методу       *}
{*                     Хафмана.                       *}
{******************************************************}
Program Hafman;
 
Uses Crt,Dos,Printer;
 
Type    PCodElement = ^CodElement;
        CodElement = record
                      NewLeft,NewRight,
                      P0, P1 : PCodElement;   {элемент входящий одновременно}
                      LengthBiteChain : byte; { в массив , очередь и дерево }
                      BiteChain : word;
                      CounterEnter : word;
                      Key : boolean;
                      Index : byte;
                     end;
 
        TCodeTable = array [0..255] of PCodElement;
 
Var     CurPoint,HelpPoint,
        LeftRange,RightRange : PCodElement;
        CodeTable : TCodeTable;
        Root : PCodElement;
        InputF, OutputF, InterF : file;
        TimeUnPakFile : longint;
        AttrUnPakFile : word;
        NumRead, NumWritten: Word;
        InBuf  : array[0..10239] of byte;
        OutBuf : array[0..10239] of byte;
        BiteChain : word;
        CRC,
        CounterBite : byte;
        OutCounter : word;
        InCounter : word;
        OutWord : word;
        St : string;
        LengthOutFile, LengthArcFile : longint;
        Create : boolean;
        NormalWork : boolean;
        ErrorByte : byte;
        DeleteFile : boolean;
{-------------------------------------------------}
 
procedure ErrorMessage;
{ --- вывод сообщения об ошибке --- }
begin
 If ErrorByte &lt;&gt; 0 then
  begin
   Case ErrorByte of
    2 : Writeln('File not found ...');
    3 : Writeln('Path not found ...');
    5 : Writeln('Access denied ...');
    6 : Writeln('Invalid handle ...');
    8 : Writeln('Not enough memory ...');
   10 : Writeln('Invalid environment ...');
.
   11 : Writeln('Invalid format ...');
   18 : Writeln('No more files ...');
   else Writeln('Error #',ErrorByte,' ...');
   end;
   NormalWork:=False;
   ErrorByte:=0;
  end;
end;
 
procedure ResetFile;
{ --- открытие файла для архивации --- }
Var St : string;
begin
  Assign(InputF, ParamStr(3));
  Reset(InputF, 1);
  ErrorByte:=IOResult;
  ErrorMessage;
  If NormalWork then Writeln('Pak file : ',ParamStr(3),'...');
end;
 
procedure ResetArchiv;
{ --- открытие файла архива, или его создание --- }
begin
  St:=ParamStr(2);
  If Pos('.',St)&lt;&gt;0 then Delete(St,Pos('.',St),4);
  St:=St+'.vsg';
  Assign(OutputF, St);
  Reset(OutPutF,1);
  Create:=False;
  If IOResult=2 then
   begin
    Rewrite(OutputF, 1);
    Create:=True;
   end;
  If NormalWork then
   If Create then Writeln('Create archiv : ',St,'...')
    else Writeln('Open archiv : ',St,'...')
end;
 
procedure SearchNameInArchiv;
{ --- в дальнейшем - поиск имени файла в архиве --- }
begin
 Seek(OutputF,FileSize(OutputF));
 ErrorByte:=IOResult;
 ErrorMessage;
end;
 
procedure DisposeCodeTable;
{ --- уничтожение кодовой таблицы и очереди --- }
Var I : byte;
begin
 For I:=0 to 255 do Dispose(CodeTable[I]);
end;
 
procedure ClosePakFile;
{ --- закрытие архивируемого файла --- }
Var I : byte;
begin
 If DeleteFile then Erase(InputF);
.
 Close(InputF);
end;
 
procedure CloseArchiv;
{ --- закрытие архивного файла --- }
begin
 If FileSize(OutputF)=0 then Erase(OutputF);
 Close(OutputF);
end;
 
procedure InitCodeTable;
{ --- инициализация таблицы кодировки --- }
Var I : byte;
begin
 For I:=0 to 255 do
  begin
    New(CurPoint);
    CodeTable[I]:=CurPoint;
    With CodeTable[I]^ do
     begin
      P0:=Nil;
      P1:=Nil;
      LengthBiteChain:=0;
      BiteChain:=0;
      CounterEnter:=1;
      Key:=True;
      Index:=I;
     end;
  end;
 For I:=0 to 255 do
  begin
   If I&gt;0 then CodeTable[I-1]^.NewRight:=CodeTable[I];
   If I&lt;255 then CodeTable[I+1]^.NewLeft:=CodeTable[I];
  end;
 LeftRange:=CodeTable[0];
 RightRange:=CodeTable[255];
 CodeTable[0]^.NewLeft:=Nil;
 CodeTable[255]^.NewRight:=Nil;
end;
 
procedure SortQueueByte;
{ --- пузырьковая сортировка по возрастанию --- }
Var Pr1,Pr2 : PCodElement;
begin
 CurPoint:=LeftRange;
 While CurPoint &lt;&gt; RightRange do
  begin
   If CurPoint^.CounterEnter &gt; CurPoint^.NewRight^.CounterEnter then
    begin
     HelpPoint:=CurPoint^.NewRight;
     HelpPoint^.NewLeft:=CurPoint^.NewLeft;
     CurPoint^.NewLeft:=HelpPoint;
     If HelpPoint^.NewRight&lt;&gt;Nil then HelpPoint^.NewRight^.NewLeft:=CurPoint;
     CurPoint^.NewRight:=HelpPoint^.NewRight;
     HelpPoint^.NewRight:=CurPoint;
     If HelpPoint^.NewLeft&lt;&gt;Nil then HelpPoint^.NewLeft^.NewRight:=HelpPoint;
     If CurPoint=LeftRange then LeftRange:=HelpPoint;
     If HelpPoint=RightRange then RightRange:=CurPoint;
     CurPoint:=CurPoint^.NewLeft;
.
     If CurPoint = LeftRange then CurPoint:=CurPoint^.NewRight
      else CurPoint:=CurPoint^.NewLeft;
    end
    else CurPoint:=CurPoint^.NewRight;
  end;
end;
 
procedure CounterNumberEnter;
{ --- подсчет частот вхождений байтов в блоке --- }
Var C : word;
begin
 For C:=0 to NumRead-1 do
  Inc(CodeTable[(InBuf[C])]^.CounterEnter);
end;
 
function SearchOpenCode : boolean;
{ --- поиск в очереди пары открытых по Key минимальных значений --- }
begin
 CurPoint:=LeftRange;
 HelpPoint:=LeftRange;
 HelpPoint:=HelpPoint^.NewRight;
 While not CurPoint^.Key do
  CurPoint:=CurPoint^.NewRight;
 While (not (HelpPoint=RightRange)) and (not HelpPoint^.Key) do
  begin
   HelpPoint:=HelpPoint^.NewRight;
   If (HelpPoint=CurPoint) and (HelpPoint&lt;&gt;RightRange) then
    HelpPoint:=HelpPoint^.NewRight;
  end;
 If HelpPoint=CurPoint then SearchOpenCode:=False else SearchOpenCode:=True;
end;
 
procedure CreateTree;
{ --- создание дерева частот вхождения --- }
begin
 While SearchOpenCode do
  begin
   New(Root);
   With Root^ do
    begin
     P0:=CurPoint;
     P1:=HelpPoint;
     LengthBiteChain:=0;
     BiteChain:=0;
     CounterEnter:=P0^.CounterEnter + P1^.CounterEnter;
     Key:=True;
     P0^.Key:=False;
     P1^.Key:=False;
    end;
   HelpPoint:=LeftRange;
   While (HelpPoint^.CounterEnter &lt; Root^.CounterEnter) and
    (HelpPoint&lt;&gt;Nil) do HelpPoint:=HelpPoint^.NewRight;
   If HelpPoint=Nil then { добавление в конец }
    begin
     Root^.NewLeft:=RightRange;
     RightRange^.NewRight:=Root;
     Root^.NewRight:=Nil;
     RightRange:=Root;
    end
.
   else
    begin { вставка перед HelpPoint }
     Root^.NewLeft:=HelpPoint^.NewLeft;
     HelpPoint^.NewLeft:=Root;
     Root^.NewRight:=HelpPoint;
     If Root^.NewLeft&lt;&gt;Nil then Root^.NewLeft^.NewRight:=Root;
    end;
  end;
end;
 
procedure ViewTree( P : PCodElement );
{ --- просмотр дерева частот и присваивание кодировочных цепей листьям --- }
Var Mask,I : word;
begin
 Inc(CounterBite);
 If P^.P0&lt;&gt;Nil then ViewTree( P^.P0 );
 If P^.P1&lt;&gt;Nil then
  begin
   Mask:=(1 SHL (16-CounterBite));
   BiteChain:=BiteChain OR Mask;
   ViewTree( P^.P1 );
   Mask:=(1 SHL (16-CounterBite));
   BiteChain:=BiteChain XOR Mask;
  end;
 If (P^.P0=Nil) and (P^.P1=Nil) then
  begin
   P^.BiteChain:=BiteChain;
   P^.LengthBiteChain:=CounterBite-1;
  end;
 Dec(CounterBite);
end;
 
procedure CreateCompressCode;
{ --- обнуление переменных и запуск просмотра дерева с вершины --- }
begin
 BiteChain:=0;
 CounterBite:=0;
 Root^.Key:=False;
 ViewTree(Root);
end;
 
procedure DeleteTree;
{ --- удаление дерева --- }
Var P : PCodElement;
begin
 CurPoint:=LeftRange;
 While CurPoint&lt;&gt;Nil do
  begin
   If (CurPoint^.P0&lt;&gt;Nil) and (CurPoint^.P1&lt;&gt;Nil) then
    begin
     If CurPoint^.NewLeft &lt;&gt; Nil then
      CurPoint^.NewLeft^.NewRight:=CurPoint^.NewRight;
     If CurPoint^.NewRight &lt;&gt; Nil then
      CurPoint^.NewRight^.NewLeft:=CurPoint^.NewLeft;
     If CurPoint=LeftRange then LeftRange:=CurPoint^.NewRight;
     If CurPoint=RightRange then RightRange:=CurPoint^.NewLeft;
     P:=CurPoint;
     CurPoint:=P^.NewRight;
     Dispose(P);
    end
.
   else CurPoint:=CurPoint^.NewRight;
  end;
end;
 
procedure SaveBufHeader;
{ --- запись в буфер заголовка архива --- }
Type
      ByteField = array[0..6] of byte;
Const
      Header : ByteField = ( $56, $53, $31, $00, $00, $00, $00 );
begin
 If Create then
  begin
   Move(Header,OutBuf[0],7);
   OutCounter:=7;
  end
 else
  begin
   Move(Header[3],OutBuf[0],4);
   OutCounter:=4;
  end;
end;
 
procedure SaveBufFATInfo;
{ --- запись в буфер всей информации по файлу --- }
Var I : byte;
    St : PathStr;
    R : SearchRec;
begin
 St:=ParamStr(3);
 For I:=0 to Length(St)+1 do
  begin
   OutBuf[OutCounter]:=byte(Ord(St[I]));
   Inc(OutCounter);
  end;
 FindFirst(St,$00,R);
 Dec(OutCounter);
 Move(R.Time,OutBuf[OutCounter],4);
 OutCounter:=OutCounter+4;
 OutBuf[OutCounter]:=R.Attr;
 Move(R.Size,OutBuf[OutCounter+1],4);
 OutCounter:=OutCounter+5;
end;
 
procedure SaveBufCodeArray;
{ --- сохранить массив частот вхождений в архивном файле --- }
Var I : byte;
begin
 For I:=0 to 255 do
  begin
   OutBuf[OutCounter]:=Hi(CodeTable[I]^.CounterEnter);
   Inc(OutCounter);
   OutBuf[OutCounter]:=Lo(CodeTable[I]^.CounterEnter);
   Inc(OutCounter);
  end;
end;
.
procedure CreateCodeArchiv;
{ --- создание кода сжатия --- }
begin
 InitCodeTable;      { инициализация кодовой таблицы                      }
 CounterNumberEnter; { подсчет числа вхождений байт в блок                }
 SortQueueByte;      { cортировка по возрастанию числа вхождений          }
 SaveBufHeader;      { сохранить заголовок архива в буфере                }
 SaveBufFATInfo;     { сохраняется FAT информация по файлу                }
 SaveBufCodeArray;   { сохранить массив частот вхождений в архивном файле }
 CreateTree;         { создание дерева частот                             }
 CreateCompressCode; { cоздание кода сжатия                               }
 DeleteTree;         { удаление дерева частот                             }
end;
 
procedure PakOneByte;
{ --- сжатие и пересылка в выходной буфер одного байта --- }
Var Mask : word;
    Tail : boolean;
begin
 CRC:=CRC XOR InBuf[InCounter];
 Mask:=CodeTable[InBuf[InCounter]]^.BiteChain SHR CounterBite;
 OutWord:=OutWord OR Mask;
 CounterBite:=CounterBite+CodeTable[InBuf[InCounter]]^.LengthBiteChain;
 If CounterBite&gt;15 then Tail:=True else Tail:=False;
 While CounterBite&gt;7 do
  begin
   OutBuf[OutCounter]:=Hi(OutWord);
   Inc(OutCounter);
   If OutCounter=(SizeOf(OutBuf)-4) then
    begin
     BlockWrite(OutputF,OutBuf,OutCounter,NumWritten);
     OutCounter:=0;
    end;
   CounterBite:=CounterBite-8;
   If CounterBite&lt;&gt;0 then OutWord:=OutWord SHL 8 else OutWord:=0;
  end;
 If Tail then
  begin
   Mask:=CodeTable[InBuf[InCounter]]^.BiteChain SHL
   (CodeTable[InBuf[InCounter]]^.LengthBiteChain-CounterBite);
   OutWord:=OutWord OR Mask;
  end;
 Inc(InCounter);
 If (InCounter=(SizeOf(InBuf))) or (InCounter=NumRead) then
  begin
   InCounter:=0;
   BlockRead(InputF,InBuf,SizeOf(InBuf),NumRead);
  end;
end;
 
procedure PakFile;
{ --- процедура непосредственного сжатия файла --- }
begin
 ResetFile;
 SearchNameInArchiv;
 If NormalWork then
  begin
   BlockRead(InputF,InBuf,SizeOf(InBuf),NumRead);
   OutWord:=0;
.
   CounterBite:=0;
   OutCounter:=0;
   InCounter:=0;
   CRC:=0;
   CreateCodeArchiv;
   While (NumRead&lt;&gt;0) do PakOneByte;
   OutBuf[OutCounter]:=Hi(OutWord);
   Inc(OutCounter);
   OutBuf[OutCounter]:=CRC;
   Inc(OutCounter);
   BlockWrite(OutputF,OutBuf,OutCounter,NumWritten);
   DisposeCodeTable;
   ClosePakFile;
  end;
end;
 
procedure ResetUnPakFiles;
{ --- открытие файла для распаковки --- }
begin
 InCounter:=7;
 St:='';
 repeat
  St[InCounter-7]:=Chr(InBuf[InCounter]);
  Inc(InCounter);
 until InCounter=InBuf[7]+8;
 Assign(InterF,St);
 Rewrite(InterF,1);
 ErrorByte:=IOResult;
 ErrorMessage;
 If NormalWork then
  begin
   WriteLn('UnPak file : ',St,'...');
   Move(InBuf[InCounter],TimeUnPakFile,4);
   InCounter:=InCounter+4;
   AttrUnPakFile:=InBuf[InCounter];
   Inc(InCounter);
   Move(InBuf[InCounter],LengthArcFile,4);
   InCounter:=InCounter+4;
  end;
end;
 
procedure CloseUnPakFile;
{ --- закрытие файла для распаковки --- }
begin
 If not NormalWork then Erase(InterF)
  else
   begin
    SetFAttr(InterF,AttrUnPakFile);
    SetFTime(InterF,TimeUnPakFile);
   end;
 Close(InterF);
end;
 
procedure RestoryCodeTable;
{ --- воссоздание кодовой таблицы по архивному файлу --- }
Var I : byte;
begin
 InitCodeTable;
 For I:=0 to 255 do
.
  begin
   CodeTable[I]^.CounterEnter:=InBuf[InCounter];
   CodeTable[I]^.CounterEnter:=CodeTable[I]^.CounterEnter SHL 8;
   Inc(InCounter);
   CodeTable[I]^.CounterEnter:=CodeTable[I]^.CounterEnter+InBuf[InCounter];
   Inc(InCounter);
  end;
end;
 
procedure UnPakByte( P : PCodElement );
{ --- распаковка одного байта --- }
Var Mask : word;
begin
 If (P^.P0=Nil) and (P^.P1=Nil) then
  begin
   OutBuf[OutCounter]:=P^.Index;
   Inc(OutCounter);
   Inc(LengthOutFile);
   If OutCounter = (SizeOf(OutBuf)-1) then
    begin
     BlockWrite(InterF,OutBuf,OutCounter,NumWritten);
     OutCounter:=0;
    end;
  end
 else
  begin
   Inc(CounterBite);
   If CounterBite=9 then
    begin
     Inc(InCounter);
     If InCounter = (SizeOf(InBuf)) then
      begin
       InCounter:=0;
       BlockRead(OutputF,InBuf,SizeOf(InBuf),NumRead);
      end;
     CounterBite:=1;
    end;
   Mask:=InBuf[InCounter];
   Mask:=Mask SHL (CounterBite-1);
   Mask:=Mask OR $FF7F; { установка всех битов кроме старшего }
   If Mask=$FFFF then UnPakByte(P^.P1)
    else UnPakByte(P^.P0);
  end;
end;
 
procedure UnPakFile;
{ --- распаковка одного файла --- }
begin
 BlockRead(OutputF,InBuf,SizeOf(InBuf),NumRead);
 ErrorByte:=IOResult;
 ErrorMessage;
 If NormalWork then ResetUnPakFiles;
 If NormalWork then
  begin
   RestoryCodeTable;
   SortQueueByte;
   CreateTree;                   { создание дерева частот }
   CreateCompressCode;
   CounterBite:=0;
.
   OutCounter:=0;
   LengthOutFile:=0;
   While LengthOutFile&lt;LengthArcFile do
    UnPakByte(Root);
   BlockWrite(InterF,OutBuf,OutCounter,NumWritten);
   DeleteTree;
   DisposeCodeTable;
  end;
 CloseUnPakFile;
end;
 
{ ------------------------- main text ------------------------- }
begin
 DeleteFile:=False;
 NormalWork:=True;
 ErrorByte:=0;
 WriteLn;
 WriteLn('ArcHaf version 1.0  (c) Copyright VVS Soft Group, 1992.');
 ResetArchiv;
 If NormalWork then
  begin
   St:=ParamStr(1);
   Case St[1] of
    'a','A' : PakFile;
    'm','M' : begin
               DeleteFile:=True;
               PakFile;
              end;
    'e','E' : UnPakFile;
    else ;
   end;
  end;
 CloseArchiv;
end.
</pre>
<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
