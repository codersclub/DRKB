<h1>Функция приблизительного (нечеткого) сравнения строк</h1>
<div class="date">01.01.2007</div>

<p class="author">Автор: Дмитрий Кузан </p>
<p>Недавно в поисках информации по интеллектуальным алгоритмам сравнения я нашел такой алгоритм &#8212; алгоритм сравнения (совпадения) двух строк, Так как он был написан на VBA, я под свои нужды переписал его на Delphi </p>
<p>Уважаемые пользователи проекта DelphiWorld, я думаю данная функция пригодится тем, кто часто пишет функции поиска, особенно когда поиск приблизителен. То есть, например, в БД забито "Иванав Иван" - с ошибкой при наборе, а ищется "Иванов". Так вот, данный алгоритм может вам найти "Иванав" при вводе "Иванов",а также при "Иван Иванов" - даже наоборот с определенной степенью релевантности при сравнении. А используя сравнение в процентном отношении, вы можете производить поиск по неточным данным с более-менее степенью похожести. </p>
<p>Еще раз повторяю, алгоритм не мой, я только его портировал на Delphi.</p>
<p>А метод был предложен Владимиром Кива, за что ему огромное спасибо. </p>
<pre>
//Функция нечеткого сравнения строк БЕЗ УЧЕТА РЕГИСТРА 
//------------------------------------------------------------------------------
//MaxMatching - максимальная длина подстроки (достаточно 3-4)
//strInputMatching - сравниваемая строка
//strInputStandart - строка-образец
 
// Сравнивание без учета регистра
// if IndistinctMatching(4, "поисковая строка", "оригинальная строка  - эталон") &gt; 40 then ...
type
  TRetCount = packed record
    lngSubRows: Word;
    lngCountLike: Word;
  end;
 
//------------------------------------------------------------------------------
 
function Matching(StrInputA: WideString;
  StrInputB: WideString;
  lngLen: Integer): TRetCount;
var
  TempRet: TRetCount;
  PosStrB: Integer;
  PosStrA: Integer;
  StrA: WideString;
  StrB: WideString;
  StrTempA: WideString;
  StrTempB: WideString;
begin
  StrA := string(StrInputA);
  StrB := string(StrInputB);
 
  for PosStrA := 1 to Length(strA) - lngLen + 1 do
  begin
    StrTempA := System.Copy(strA, PosStrA, lngLen);
 
    PosStrB := 1;
    for PosStrB := 1 to Length(strB) - lngLen + 1 do
    begin
      StrTempB := System.Copy(strB, PosStrB, lngLen);
      if SysUtils.AnsiCompareText(StrTempA, StrTempB) = 0 then
      begin
        Inc(TempRet.lngCountLike);
        break;
      end;
    end;
 
    Inc(TempRet.lngSubRows);
  end; // PosStrA
 
  Matching.lngCountLike := TempRet.lngCountLike;
  Matching.lngSubRows := TempRet.lngSubRows;
end; { function }
 
//------------------------------------------------------------------------------
 
function IndistinctMatching(MaxMatching: Integer;
  strInputMatching: WideString;
  strInputStandart: WideString): Integer;
var
  gret: TRetCount;
  tret: TRetCount;
  lngCurLen: Integer; //текущая длина подстроки
begin
    //если не передан какой-либо параметр, то выход
  if (MaxMatching = 0) or (Length(strInputMatching) = 0) or
    (Length(strInputStandart) = 0) then
  begin
    IndistinctMatching := 0;
    exit;
  end;
 
  gret.lngCountLike := 0;
  gret.lngSubRows := 0;
    // Цикл прохода по длине сравниваемой фразы
  for lngCurLen := 1 to MaxMatching do
  begin
        //Сравниваем строку A со строкой B
    tret := Matching(strInputMatching, strInputStandart, lngCurLen);
    gret.lngCountLike := gret.lngCountLike + tret.lngCountLike;
    gret.lngSubRows := gret.lngSubRows + tret.lngSubRows;
        //Сравниваем строку B со строкой A
    tret := Matching(strInputStandart, strInputMatching, lngCurLen);
    gret.lngCountLike := gret.lngCountLike + tret.lngCountLike;
    gret.lngSubRows := gret.lngSubRows + tret.lngSubRows;
  end;
 
  if gret.lngSubRows = 0 then
  begin
    IndistinctMatching := 0;
    exit;
  end;
 
  IndistinctMatching := Trunc((gret.lngCountLike / gret.lngSubRows) * 100);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
&nbsp;</p>
<hr />
<pre>
uses
   Math;
 
 function DoStringMatch(s1, s2: string): Double;
 var
   i, iMin, iMax, iSameCount: Integer;
 begin
   iMax := Max(Length(s1), Length(s2));
   iMin := Min(Length(s1), Length(s2));
   iSameCount := -1;
   for i := 0 to iMax do
   begin
     if i &gt; iMin then
       break;
     if s1[i] = s2[i] then
       Inc(iSameCount)
     else
       break;
   end;
   if iSameCount &gt; 0 then
     Result := (iSameCount / iMax) * 100
   else
     Result := 0.00;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   match: Double;
 begin
   match := DoStringMatch('SwissDelphiCenter', 'SwissDelphiCenter.ch');
   ShowMessage(FloatToStr(match) + ' % match.');
   // Resultat: 85% 
  // Result  : 85% 
end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
&nbsp;</p>
