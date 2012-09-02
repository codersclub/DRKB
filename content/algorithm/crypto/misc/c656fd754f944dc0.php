<h1>Как проверить правильность номера кредитной карточки?</h1>
<div class="date">01.01.2007</div>


<pre>
{------------------------------------------------- 
  Returns:  
 
   0  : Card is invalid or unknown 
   1  : Card is a valid AmEx 
   2  : Card is a valid Visa 
   3  : Card is a valid MasterCard 
 
  Ergebnis:  
 
   0  : Unbekannte Karte 
   1  : AmEx Karte 
   2  : Visa Karte 
   3  : MasterCard Karte 
-------------------------------------------------}  
 
function CheckCC(c: string): Integer; 
var  
  card: string[21];  
  Vcard: array[0..21] of Byte absolute card;  
  Xcard: Integer;  
  Cstr: string[21]; 
  y, x: Integer;  
begin  
  Cstr := '';  
  FillChar(Vcard, 22, #0); 
  card := c;  
  for x := 1 to 20 do  
    if (Vcard[x] in [48..57]) then  
      Cstr := Cstr + chr(Vcard[x]);  
  card := ''; 
  card := Cstr; 
  Xcard := 0;  
  if not odd(Length(card)) then  
    for x := (Length(card) - 1) downto 1 do  
    begin  
      if odd(x) then 
        y := ((Vcard[x] - 48) * 2) 
      else  
        y := (Vcard[x] - 48);  
      if (y &gt;= 10) then  
        y := ((y - 10) + 1);  
      Xcard := (Xcard + y)  
    end  
  else 
    for x := (Length(card) - 1) downto 1 do 
    begin 
      if odd(x) then  
        y := (Vcard[x] - 48)  
      else  
        y := ((Vcard[x] - 48) * 2);  
      if (y &gt;= 10) then  
        y := ((y - 10) + 1); 
      Xcard := (Xcard + y)  
    end;  
  x := (10 - (Xcard mod 10));  
  if (x = 10) then 
    x := 0;  
  if (x = (Vcard[Length(card)] - 48)) then 
    Result := Ord(Cstr[1]) - Ord('2') 
  else  
    Result := 0 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  case CheckCC(Edit1.Text) of 
    0: Label1.Caption := 'Card is invalid or unknown'; 
    1: Label1.Caption := 'Card is a valid AmEx'; 
    2: Label1.Caption := 'Card is a valid Visa'; 
    3: Label1.Caption := 'Card is a valid MasterCard'; 
  end; 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
<hr />
<pre>
unit Creditc;
 
{*****************************************************************************
 
Модуль Delphi для проверки номера кредитной карты
 
Версия: 1.1
Дата: Декабрь 20, 1996
 
Данный модуль создан на основе алгоритма ccard автора Peter Miller.
Автор не против бесплатного использования, но резервирует все права
на данный алгоритм.
 
авторское право 1996 Shawn Wilson Harvell ( shawn@inet.net )
 
применение:
 
Внесите данный модуль в список uses любого модуля, которому
необходим доступ к функции проверки кредитной карты.
 
IsValidCreditCardNumber( CardNumber, ReturnMessage ) returns Boolean
 
например, используйте это для уведомления пользователя о недействительности карты.
 
CardNumber - строка, содержащая номер карты, которую необходимо проверить
ReturnMessage - строка, с помощью которой функция может возвратить любое сообщение
( при этом старое содержимое строки стирается )
 
возвращает true если номер карточки верен, false - в противном случае.
 
во входных параметрах функции допускаются тире и пробелы,
если же возможно присутствие других символов, вы можете их удалить.
Функция RemoveChar довольно легко позаботится об этом, просто
передайте ей входную строку и символ, который вы хотите удалить.
 
Пользователь может свободно изменять код модуля для собственных целей,
но в случае его распространения он должен сообщить пользователям
обо всех внесенных изменениях.
 
Используйте модуль на свой страх и риск, поскольку он свободен от явных
и неявных гарантий. Ответственность за какой-либо ущерб, причиненный
данным модулем лежит на его пользователе.
 
На момент написания модуля он устойчиво работал под Delphi версий 1 и 2,
для Turbo Pascal необходимо внести некоторые несложные исправления (главным
образом из-за различия реализации функций в модуле SysUtils).
 
Если вы нашли этот модуль полезным, имеете какие-то пожелания или предложения,
отправьте автору письмо по адресу электронной почты shawn@inet.net
 
История изменений
 
версия 1.1 -- Декабрь 20, 1996
исправлена ошибка с Discover card: соответственно увеличина длина маски "database"
 
версия 1.0 -- Октябрь 26, 1996
первый выпуск
 
*****************************************************************************}
 
interface
 
uses SysUtils;
 
function IsValidCreditCardNumber(CardNumber: string; var MessageText: string):
  Boolean;
 
implementation
 
const
 
  CardPrefixes: array[1..19] of string =
  ('2014', '2149', '300', '301', '302',
    '303', '304', '305', '34', '36', '37',
    '38', '4', '51', '52', '53', '54', '55', '6011');
 
  CardTypes: array[1..19] of string =
  ('enRoute',
    'enRoute',
    'Diner Club/Carte Blanche',
    'Diner Club/Carte Blanche',
    'Diner Club/Carte Blanche',
    'Diner Club/Carte Blanche',
    'Diner Club/Carte Blanche',
    'Diner Club/Carte Blanche',
    'American Express',
    'Diner Club/Carte Blanche',
    'American Express',
    'Diner Club/Carte Blanche',
    'Visa',
    'MasterCard',
    'MasterCard',
    'MasterCard',
    'MasterCard',
    'MasterCard',
    'Discover');
 
function RemoveChar(const Input: string; DeletedChar: Char): string;
var
 
  Index: Word; { переменная счетчика                           }
begin
 
  { данная функция удаляет все вхождения указанного символа из переданной ей      }
  { строки                                                                        }
  Result := Input;
  for Index := Length(Result) downto 1 do
    if Result[Index] = DeletedChar then
      Delete(Result, Index, 1);
end;
 
function ShiftMask(Input: Integer): Integer;
begin
 
  { простая оболочка для функции сдвига битов числа                              }
  result := (1 shl (Input - 12));
end;
 
function ConfirmChecksum(CardNumber: string): Boolean;
var
 
  CheckSum: Integer; { Содержит значение операции                    }
  Flag: Boolean; { флаг готовности                               }
  Counter: Integer; { индекс счетчика                               }
  PartNumber: string; { используется для извлечения каждой цифры числа}
  Number: Integer; { исп-ся для преобразования каждой цифры в число}
begin
 
  {**************************************************************************
  Это, вероятно, самая запутанный код, который вы когда-либо видели, я и сам
  запутался, когда работал над ним. Основное, что делает данная функция -
  извлекает каждую цифру из номера карты для использования в формуле проверки
  контрольной суммы, устанавливаемую компаниями. Алгоритм производит выборку,
  начиная от последней цифры и заканчивая первой.
  **************************************************************************}
 
  { получаем стартовое значение счетчика }
  Counter := Length(CardNumber);
  CheckSum := 0;
  PartNumber := '';
  Number := 0;
  Flag := false;
 
  while (Counter &gt;= 1) do
  begin
    { получаем текущую цифру }
    PartNumber := Copy(CardNumber, Counter, 1);
    Number := StrToInt(PartNumber); { преобразуем в число }
    if (Flag) then { только каждую вторую цифру }
    begin
      Number := Number * 2;
      if (Number &gt;= 10) then
        Number := Number - 9;
    end;
    CheckSum := CheckSum + Number;
 
    Flag := not (Flag);
 
    Counter := Counter - 1;
  end;
 
  result := ((CheckSum mod 10) = 0);
end;
 
function GetMask(CardName: string): Integer;
begin
 
  { значение по умолчанию }
  result := 0;
 
  if (CardName = 'MasterCard') then
    result := ShiftMask(16);
  if (CardName = 'Visa') then
    result := (ShiftMask(13) or ShiftMask(16));
  if (CardName = 'American Express') then
    result := ShiftMask(15);
  if (CardName = 'Diner Club/Carte Blanche') then
    result := ShiftMask(14);
  if (CardName = 'Discover') then
    result := ShiftMask(16);
 
end;
 
function IsValidCreditCardNumber(CardNumber: string; var MessageText: string):
  Boolean;
var
 
  StrippedNumber: string;
    { используется для хранения числа без дополнительных символов }
  Index: Integer; { универсальный счетчик для циклов и т.п.                     }
  TheMask: Integer;
    { число, которое мы будем использовать для маски              }
  FoundIt: Boolean;
    { используется для индикации, когда что-либо найдено          }
  CardName: string;
    { хранит имя типа карты                                       }
  PerformChecksum: Boolean;
    { тип enRoute карты если контрольная сумма не сошлась         }
begin
 
  { сначала избавимся от пробелов и тире }
  StrippedNumber := RemoveChar(CardNumber, ' ');
  StrippedNumber := RemoveChar(StrippedNumber, '-');
 
  { если строка была нулевой длины, то тоже OK }
  if (StrippedNumber = '') then
  begin
    result := true;
    exit;
  end;
 
  { инициализация возвращаемых переменных }
  MessageText := '';
  result := true;
 
  { устанавливаем нашу переменную-флаг }
  FoundIt := false;
 
  { проверка правильности введенных символов в номере карты }
  for Index := 1 to Length(StrippedNumber) do
  begin
    case StrippedNumber[Index] of
      '0'..'9': FoundIt := FoundIt; { другими словами не op }
    else
      MessageText := 'Неверный введенный символ';
      result := false;
      exit;
    end;
  end;
 
  { теперь давайте определим тип используемой карты }
  for Index := 1 to 19 do
  begin
    if (Pos(CardPrefixes[Index], StrippedNumber) = 1) then
    begin
      { мы обнаружили правильный тип }
      FoundIt := true;
      CardName := CardTypes[Index];
      TheMask := GetMask(CardName);
    end;
  end;
 
  { если тип карты не определен, указываем на это }
  if (not FoundIt) then
  begin
    CardName := 'Unknown Card Type';
    TheMask := 0;
    MessageText := 'Неизвестный тип карты ';
    result := false;
    exit;
  end;
 
  { проверка длины }
  if ((Length(StrippedNumber) &gt; 28) and result) then
  begin
    MessageText := 'Номер слишком большой ';
    result := false;
    exit;
  end;
 
  { проверка длины }
  if ((Length(StrippedNumber) &lt; 12) or
    ((shiftmask(length(strippednumber)) and themask) = 0)) then
  begin
    messagetext := 'неверная длина числа';
    result := false;
    exit;
  end;
 
  { проверяем вычисление контрольной суммы }
  if (cardname = 'enroute') then
    performchecksum := false
  else
    performchecksum := true;
 
  if (performchecksum and (not confirmchecksum(strippednumber))) then
  begin
    messagetext := 'неверная контрольная сумма';
    result := false;
    exit;
  end;
 
  { если результат равен true, тогда все ok }
  if (result) then
    messagetext := 'номер верен: тип карты: ' + cardname;
 
  { если строка была нулевой длины, то тоже OK }
  if (strippednumber = '') then
    result := true;
 
end;
 
end.
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
