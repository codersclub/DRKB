<h1>Вычисление даты Пасхи</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Mark Lussier&nbsp; </p>
<pre>
function TtheCalendar.CalcEaster: string;
var
  B, D, E, Q: Integer;
 
  GF: string;
begin
 
  B := 225 - 11 * (Year mod 19);
  D := ((B - 21) mod 30) + 21;
  if D &gt; 48 then
    Dec(D);
  E := (Year + (Year div 4) + D + 1) mod 7;
  Q := D + 7 - E;
  if Q &lt; 32 then
  begin
    if ShortDateFormat[1] = 'd' then
      Result := IntToStr(Q) + '/3/' + IntToStr(Year)
 
    else
      Result := '3/' + IntToStr(Q) + '/' + IntToStr(Year);
  end
  else
  begin
    if ShortDateFormat[1] = 'd' then
      Result := IntToStr(Q - 31) + '/4/' + IntToStr(Year)
 
    else
      Result := '4/' + IntToStr(Q - 31) + '/' + IntToStr(Year);
  end;
  {вычисление страстной пятницы}
  if Q &lt; 32 then
  begin
    if ShortDateFormat[1] = 'd' then
      GF := IntToStr(Q - 2) + '/3/' + IntToStr(Year)
    else
      GF := '3/' + IntToStr(Q - 2) + '/' + IntToStr(Year);
  end
  else
  begin
    if ShortDateFormat[1] = 'd' then
      GF := IntToStr(Q - 31 - 2) + '/4/' + IntToStr(Year)
 
    else
      GF := '4/' + IntToStr(Q - 31 - 2) + '/' + IntToStr(Year);
  end;
 
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<pre>
function Easter(Year: Integer): TDateTime;
{----------------------------------------------------------------}
{ Вычисляет и возвращает день Пасхи определенного года.          }
{ Идея принадлежит Mark Lussier, AppVision &lt;MLussier@best.com&gt;.  }
{ Скорректировано для предотвращения переполнения целых, если по }
{ ошибке передан год с числом 6554 или более.                    }
{----------------------------------------------------------------}
 
var
  nMonth, nDay, nMoon, nEpact, nSunday,
    nGold, nCent, nCorx, nCorz: Integer;
begin
  { Номер Золотого Года в 19-летнем Metonic-цикле: }
  nGold := (Year mod 19) + 1;
  { Вычисляем столетие: }
  nCent := (Year div 100) + 1;
  { Количество лет, в течение которых отслеживаются високосные года... }
  { для синхронизации с движением солнца: }
  nCorx := (3 * nCent) div 4 - 12;
  { Специальная коррекция для синхронизации Пасхи с орбитой луны: }
  nCorz := (8 * nCent + 5) div 25 - 5;
  { Находим воскресенье: }
  nSunday := (Longint(5) * Year) div 4 - nCorx - 10;
  { ^ Предохраняем переполнение года за отметку 6554}
  { Устанавливаем Epact - определяем момент полной луны: }
  nEpact := (11 * nGold + 20 + nCorz - nCorx) mod 30;
  if nEpact &lt; 0 then
    nEpact := nEpact + 30;
  if ((nEpact = 25) and (nGold &gt; 11)) or (nEpact = 24) then
    nEpact := nEpact + 1;
  { Ищем полную луну: }
  nMoon := 44 - nEpact;
  if nMoon &lt; 21 then
    nMoon := nMoon + 30;
  { Позиционируем на воскресенье: }
  nMoon := nMoon + 7 - ((nSunday + nMoon) mod 7);
  if nMoon &gt; l 31 then
  begin
    nMonth := 4;
    nDay := nMoon - 31;
  end
  else
  begin
    nMonth := 3;
    nDay := nMoon;
  end;
  Easter := EncodeDate(Year, nMonth, nDay);
end; {Easter}
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p class="note">Примечание от Vit</p>
<p>Что-то настораживает меня тот факт что автор кода имеет "западную" фамилию, почти наверняка код этот вычисляет время наступления католической Пасхи или иудейского праздника Пейсах (неправильно именуемого в просторечье "еврейской пасхой"), а вовсе не православной Пасхи. Православная пасха обычно сдвинута на неделю вперёд, но бывают и исключения (доподлинно алгоритм вычисления мне неизвестен), а потому пользоваться кодом надо с оглядкой...</p>

