<h1>Как реализовать поиск, замену</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  if OpenDialog1.Execute then
    Memo1.Lines.LoadFromFile(OpenDialog1.FileName);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var
  find: string;
  text: string;
  st, len: integer;
  res: integer;
begin
  if Memo1.SelStart &gt;= Length(Memo1.Text) then
    Memo1.SelStart := 0;
  st := Memo1.SelStart + 1;
  if (Memo1.SelLength &lt;= 0) or (not CheckBox1.Checked) then
  begin
    inc(st, Memo1.SelLength);
    len := Length(Memo1.Text) - st;
  end
  else
    len := Memo1.SelLength;
  text := copy(Memo1.Text, st, len);
  find := Edit1.Text;
  res := pos(find, text);
  if res = 0 then
  begin
    ShowMessage('Search string "' + find + '" not found');
    Exit;
  end;
  Memo1.SelStart := res + st - 2;
  Memo1.SelLength := length(find);
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
<hr />
<p class="p_Heading1">Поиск и замена текста в TMemo</p>
<pre>
procedure TForm1.FindDialog1Find(Sender: TObject);
var
  Buff, P, FT: PChar;
  BuffLen: Word;
begin
  with Sender as TFindDialog do
  begin
    GetMem(FT, Length(FindText) + 1);
    StrPCopy(FT, FindText);
    BuffLen := Memo1.GetTextLen + 1;
    GetMem(Buff, BuffLen);
    Memo1.GetTextBuf(Buff, BuffLen);
    P := Buff + Memo1.SelStart + Memo1.SelLength;
    P := StrPos(P, FT);
    if P = nil then
      MessageBeep(0)
    else
    begin
      Memo1.SelStart := P - Buff;
      Memo1.SelLength := Length(FindText);
    end;
    FreeMem(FT, Length(FindText) + 1);
    FreeMem(Buff, BuffLen);
  end;
end;
 
procedure TForm1.ReplaceDialog1Replace(Sender: TObject);
begin
  with Sender as TReplaceDialog do
    while True do
    begin
      if Memo1.SelText &lt;&gt; FindText then
        FindDialog1Find(Sender);
      if Memo1.SelLength = 0 then
        Break;
      Memo1.SelText := ReplaceText;
      if not (frReplaceAll in Options) then
        Break;
    end;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Поиск и замена текста в поле МЕМО программно
 
На форму бросьте кнопку и поле МЕМО
напишите в МЕМО(в первой строке) текст и поставьте C:\, нажмите кнопку,
при этом C:\ замениться на D:\ без потери форматирования
Вот и все...
 
Зависимости: Смотрите uses
Автор:       Mirag, wwwMirage@yandex.ru, Mirag
Copyright:   Mirag
Дата:        15 ноября 2002 г.
***************************************************** }
 
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    Label1: TLabel;
    Memo1: TMemo;
    procedure Button1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
  result: boolean;
implementation
 
{$R *.dfm}
 
function ReplaceSub(str, sub1, sub2: string): string;
var
  aPos: Integer;
  rslt: string;
begin
  aPos := Pos(sub1, str);
  rslt := '';
  while (aPos &lt;&gt; 0) do
  begin
    rslt := rslt + Copy(str, 1, aPos - 1) + sub2;
    Delete(str, 1, aPos + Length(sub1) - 1);
    aPos := Pos(sub1, str);
  end;
  Result := rslt + str;
end;
 
function MatchStrings(source, pattern: string): Boolean;
var
 
  pSource: array[0..255] of Char;
  pPattern: array[0..255] of Char;
 
  function MatchPattern(element, pattern: PChar): Boolean;
 
    function IsPatternWild(pattern: PChar): Boolean;
    var
      t: Integer;
    begin
      Result := StrScan(pattern, '*') &lt;&gt; nil;
      if not Result then
        Result := StrScan(pattern, '?') &lt;&gt; nil;
    end;
 
  begin
    if 0 = StrComp(pattern, '*') then
      Result := True
    else if (element^ = Chr(0)) and (pattern^ &lt;&gt; Chr(0)) then
      Result := False
    else if element^ = Chr(0) then
      Result := True
    else
    begin
      case pattern^ of
        '*': if MatchPattern(element, @pattern[1]) then
            Result := True
          else
            Result := MatchPattern(@element[1], pattern);
        '?': Result := MatchPattern(@element[1], @pattern[1]);
      else
        if element^ = pattern^ then
          Result := MatchPattern(@element[1], @pattern[1])
        else
          Result := False;
      end;
    end;
  end;
 
begin
 
  StrPCopy(pSource, source);
  StrPCopy(pPattern, pattern);
  Result := MatchPattern(pSource, pPattern);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  ss: string;
begin
  result := MatchStrings(memo1.Lines.Text, '*c:\*');
  if result = true then
  begin
    messagebox(0, '', '', MB_OK);
    ss := ReplaceSub(memo1.Lines.Strings[0], 'c:\', 'd:\');
    memo1.Lines.Delete(0);
    memo1.Lines.Insert(0, ss);
  end;
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
 
end;
 
end.
 
 
 
</pre>
</p>
<hr />
<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Поиск строки в редакторе Memo
 
Зависимости: Windows, Classes, StdCtrls
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Автор: Федоровских Николай
Дата:        26 июня 2002 г.
***************************************************** }
 
function FindInMemo(Memo: TMemo; const FindText: string;
  FindDown, MatchCase: Boolean): Boolean;
 
{Если строка найдена, то результат True, иначе - False;
 
 FindText : искомая строка;
 FindDown : True - поиск вниз от курсора ввода;
             False - поиск вверх от курсора ввода;
 MatchCase : True - с учетом регистра букв,
             False - не учитывая регистр бук.
 
 Если у Memo стоит автоперенос слов, то могут
 возникнуть проблемы - текст будет найден,
 но выделен не там где надо. Так что, для нормального поиска
 свойство ScrollBars у Memo ставить в ssBoth (ну или ssHorizontal)}
 
  function PosR2L(const FindStr, SrcStr: string): Integer;
    {Поиск последнего вхождения подстроки FindStr в строку SrcStr}
  var
    ps, L: Integer;
 
    function InvertSt(const S: string): string;
      {Инверсия строки S}
    var
      i: Integer;
    begin
      L := Length(S);
      SetLength(Result, L);
      for i := 1 to L do
        Result[i] := S[L - i + 1];
    end;
 
  begin
    ps := Pos(InvertSt(FindStr), InvertSt(SrcStr));
    if ps &lt;&gt; 0 then
      Result := Length(SrcStr) - Length(FindStr) - ps + 2
    else
      Result := 0;
  end;
 
  function MCase(const s: string): string;
    {Перевод заглавных букв в строчные;
     Функция вызывается если регистр не учитывается}
  var
    i: Integer;
  begin
    Result := s;
    for i := 1 to Length(s) do
    begin
      case s[i] of
        'A'..'Z',
          'А'..'Я': Result[i] := Chr(Ord(s[i]) + 32);
        'Ё': Result[i] := 'ё';
        'Ѓ': Result[i] := 'ѓ';
        'Ґ': Result[i] := 'ґ';
        'Є': Result[i] := 'є';
        'Ї': Result[i] := 'ї';
        'І': Result[i] := 'і';
        'Ѕ': Result[i] := 'ѕ';
      end;
    end;
  end;
 
var
  Y, X, SkipChars: Integer;
  FindS, SrcS: string;
  P: TPoint;
begin
  Result := False;
 
  if MatchCase then
    FindS := FindText
  else
    FindS := MCase(FindText);
 
  P := Memo.CaretPos;
 
  if FindDown then
    {Поиск вправо и вниз от курсора ввода}
    for Y := P.y to Memo.Lines.Count do
    begin
 
      if Y &lt;&gt; P.y then
        {Если это не строка, в которой курсор вода,
         то ищем во всей строке}
        SrcS := Memo.Lines[Y]
      else
        {иначе обрезаем строку от курсора до конца}
        SrcS := Copy(Memo.Lines[Y], P.x + 1,
          Length(Memo.Lines[Y]) - P.x + 1);
 
      if not MatchCase then
        SrcS := MCase(SrcS);
      X := Pos(FindS, SrcS);
      if X &lt;&gt; 0 then
      begin
        if Y = P.y then
          Inc(X, P.x);
        P := Point(X, Y);
        Result := True;
        Break; {Выход из цикла}
      end
    end
  else
    {Поиск влево и вверх от курсора ввода}
    for Y := P.y downto 0 do
    begin
 
      if Y &lt;&gt; P.y then
        {Если это не строка, в которой курсор вода,
         то ищем во всей строке}
        SrcS := Memo.Lines[Y]
      else
        {иначе обрезаем строку от начала до курсора
         минус выделенный текст}
        SrcS := Copy(Memo.Lines[Y], 1, P.x - Memo.SelLength);
 
      if not MatchCase then
        SrcS := MCase(SrcS);
      X := PosR2L(FindS, SrcS);
      if X &lt;&gt; 0 then
      begin
        P := Point(X, Y);
        Result := True;
        Break; {Выход из цикла}
      end
    end;
 
  if Result then
  begin
    {Если текст найден - выделяем его}
    SkipChars := 0;
    for y := 0 to P.Y - 1 do
      Inc(SkipChars, Length(Memo.Lines[y]));
    Memo.SelStart := SkipChars + (P.Y * 2) + P.X - 1;
    Memo.SelLength := Length(FindText);
  end;
end;
Пример использования: 
 
procedure TForm1.FindDialog1Find(Sender: TObject);
begin
  if not FindInMemo(Memo1,
    FindDialog1.FindText,
    frDown in FindDialog1.Options,
    frMatchCase in FindDialog1.Options) then
    Application.MessageBox('Поиск результатов не дал.',
      PChar(Application.Title),
      MB_OK or MB_ICONINFORMATION);
end;
</pre>
</p>
<hr />
<p>Пришло мне письмо от Алексея. На этот раз он прислал (цитирую): "юнит для поиска строки(текста) в TEdit, TMemo, или других компонентах (дочерних TCustomEdit'у)." Так как тескт "авторский" (более того, здесь также присутствует наследование), помещаю его здесь в том виде, в котором он был прислан, т.е. без перевода. В случае каких-либо вопросов и недоразумений обращайтесь по вышеуказанносу адресу электронной почты.</p>
<pre>
{ПРИМЕР :
 
[...]
 
implementation
 
uses Search;}
{$R *.DFM}
 
{procedure TForm1.Button1Click(Sender: TObject);
begin
 
SearchMemo(RichEdit1, 'Найди меня', [frDown]);
end;
 
В опции поиска можно подключать, отключать, комбинировать следующие
параметры:
frDown - указывает на то, что происходит поиск вниз по тексту от курсора(при
отключенном frDown'е будет происходит поиск вверх по тексту).
frMatchCase - указывает на то, что следует проводить поиск с учетом
регистра.
frWholeWord - указывает на то, что следует искать только слово целиком.
 
[...]
 
Авторские права на этот юнит пренадлежат неизвесно кому.
 
В каком виде этот юнит попал мне, практически в этом же
виде я отдаю его вам. Пользуйтесь и благодарите неизвесного
героя.}
 
unit Search;
 
interface
 
uses
 
  WinProcs, SysUtils, StdCtrls, Dialogs;
 
const
  {****************************************************************************
 
  * Default word delimiters are any character except the core alphanumerics. *
  ****************************************************************************}
  WordDelimiters: set of Char = [#0..#255] - ['a'..'z', 'A'..'Z', '1'..'9',
    '0'];
  {******************************************************************************
 
  * SearchMemo scans the text of a TEdit, TMemo, or other TCustomEdit-derived  *
  * component for a given search string. The search starts at the current      *
  * caret position in the control.  The Options parameter determines whether   *
  * the search runs forward (frDown) or backward from the caret position,      *
  * whether or not the text comparison is case sensitive, and whether the      *
  * matching string must be a whole word.  If text is already selected in the  *
  * control, the search starts at the 'far end' of the selection (SelStart if  *
  * searching backwards, SelEnd if searching forwards).  If a match is found,  *
  * the control's text selection is changed to select the found text and the   *
  * function returns True.  If no match is found, the function returns False.  *
  ******************************************************************************}
function SearchMemo(Memo: TCustomEdit;
 
  const SearchString: string;
  Options: TFindOptions): Boolean;
{******************************************************************************
 
* SearchBuf is a lower-level search routine for arbitrary text buffers.      *
* Same rules as SearchMemo above. If a match is found, the function returns  *
* a pointer to the start of the matching string in the buffer. If no match,  *
* the function returns nil.                                                  *
******************************************************************************}
function SearchBuf(Buf: PChar; BufLen: Integer;
 
  SelStart, SelLength: Integer;
  SearchString: string;
  Options: TFindOptions): PChar;
 
implementation
 
function SearchMemo(Memo: TCustomEdit;
 
  const SearchString: string;
  Options: TFindOptions): Boolean;
var
 
  Buffer, P: PChar;
  Size: Word;
begin
 
  Result := False;
  if (Length(SearchString) = 0) then
    Exit;
  Size := Memo.GetTextLen;
  if Size = 0 then
    Exit;
  Buffer := StrAlloc(Size + 1);
  try
    Memo.GetTextBuf(Buffer, Size + 1);
    P := SearchBuf(Buffer, Size, Memo.SelStart, Memo.SelLength, SearchString,
      Options);
    if P &lt;&gt; nil then
    begin
      Memo.SelStart := P - Buffer;
      Memo.SelLength := Length(SearchString);
      Result := True;
    end;
  finally
    StrDispose(Buffer);
  end;
end;
 
function SearchBuf(Buf: PChar; BufLen: Integer;
 
  SelStart, SelLength: Integer;
  SearchString: string;
  Options: TFindOptions): PChar;
var
 
  SearchCount, I: Integer;
  C: Char;
  Direction: Shortint;
  CharMap: array[Char] of Char;
 
  function FindNextWordStart(var BufPtr: PChar): Boolean;
  begin { (True XOR N) is equivalent to (not N) }
    //    Result := False;      { (False XOR N) is equivalent to (N)    }
 
    { When Direction is forward (1), skip non delimiters, then skip delimiters. }
    { When Direction is backward (-1), skip delims, then skip non delims }
 
    while (SearchCount &gt; 0) and
      ((Direction = 1) xor
      (BufPtr^ in WordDelimiters)) do
    begin
      Inc(BufPtr, Direction);
      Dec(SearchCount);
    end;
 
    while (SearchCount &gt; 0) and
      ((Direction = -1) xor
      (BufPtr^ in WordDelimiters)) do
    begin
      Inc(BufPtr, Direction);
      Dec(SearchCount);
    end;
 
    Result := SearchCount &gt; 0;
    if Direction = -1 then
    begin {back up one char, to leave ptr on first non delim}
      Dec(BufPtr, Direction);
      Inc(SearchCount);
    end;
  end;
 
begin
 
  Result := nil;
 
  if BufLen &lt;= 0 then
    Exit;
 
  if frDown in Options then
  begin {if frDown...}
    Direction := 1;
    Inc(SelStart, SelLength); { start search past end of selection }
    SearchCount := BufLen - SelStart - Length(SearchString);
 
    if SearchCount &lt; 0 then
      Exit;
 
    if Longint(SelStart) + SearchCount &gt; BufLen then
      Exit;
 
  end {if frDown...}
  else
  begin {else}
    Direction := -1;
    Dec(SelStart, Length(SearchString));
    SearchCount := SelStart;
  end; {else}
 
  if (SelStart &lt; 0) or (SelStart &gt; BufLen) then
    Exit;
 
  Result := @Buf[SelStart];
  { Using a Char map array is faster than calling AnsiUpper on every character }
 
  for C := Low(CharMap) to High(CharMap) do
    CharMap[C] := C;
 
  if not (frMatchCase in Options) then
  begin {if not (frMatchCase}
    AnsiUpperBuff(PChar(@CharMap), sizeof(CharMap));
    AnsiUpperBuff(@SearchString[1], Length(SearchString));
  end; {if not (frMatchCase}
 
  while SearchCount &gt; 0 do
  begin {while SearchCount}
    if frWholeWord in Options then
    begin
      if not FindNextWordStart(Result) then
        Break;
    end;
    I := 0;
 
    while (CharMap[Result[I]] = SearchString[I + 1]) do
    begin {while (CharMap...}
      Inc(I);
      if I &gt;= Length(SearchString) then
      begin {if I &gt;=...}
        if (not (frWholeWord in Options)) or
          (SearchCount = 0) or
          (Result[I] in WordDelimiters) then
          Exit;
        Break;
      end; {if I &gt;=...}
    end; {while (CharMap...}
 
    Inc(Result, Direction);
    Dec(SearchCount);
  end; {while SearchCount}
 
  Result := nil;
end;
 
end.
 
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

