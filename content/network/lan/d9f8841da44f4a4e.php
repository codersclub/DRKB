<h1>Получить список пользователей, подключенных к сети</h1>
<div class="date">01.01.2007</div>


<pre>
unit NetUtils;
 
interface
 
uses
  Windows, Classes;
 
function GetContainerList(ListRoot:PNetResource):TList;
 
type
  {$H+}
  PNetRes = ^TNetRes;
  TNetRes = record
    dwScope : Integer;
    dwType : Integer;
    dwDisplayType : Integer;
    dwUsage : Integer;
    LocalName : string;
    RemoteName : string;
    Comment : string;
    Provider : string;
  end;
  {H-}
 
 
implementation
 
uses SysUtils;
 
type
  PnetResourceArr = ^TNetResource;
 
function GetContainerList(ListRoot:PNetResource):TList;
{возвращает список сетевых имён с подуровня ListRoot, каждый
элемент списка TList - это PNetRec, где поле RemoteName определяет
соответственно сетевое имя элемента списка. Если ListRoot=nil, то
возвращается самый верхний уровень типа:
1. Microsoft Windows Network
2. Novell Netware Network
Чтобы получить список доменов сети Microsoft, нужно вызвать эту
функцию второй раз, передав ей в качестве параметра,
соответствующий элемент списка, полученного при первом её вызове.
Чтобы получить список компьютеров домена - вызвать третий раз...}
var
  TempRec : PNetRes;
  Buf : Pointer;
  Count,
  BufSize,
  Res : DWORD;
  lphEnum : THandle;
  p : PNetResourceArr;
  i : SmallInt;
  NetworkList : TList;
begin
  NetworkList := TList.Create;
  Result:=nil;
  BufSize := 8192;
  GetMem(Buf, BufSize);
  try
    Res := WNetOpenEnum(RESOURCE_GLOBALNET, RESOURCETYPE_DISK,
    RESOURCEUSAGE_CONTAINER{0}, ListRoot,lphEnum);
    {в результате получаем ссылку lphEnum}
    if Res &lt;&gt; 0 then
      raise Exception(Res);
    Count := $FFFFFFFF; {требуем выдать столько записей в список, сколько есть}
    Res := WNetEnumResource(lphEnum, Count, Buf, BufSize);
    {в буфере Buf - списочек в виде массива указателей на структуры
    типа TNetResourceArr, а в Count - число этих структур}
    if Res = ERROR_NO_MORE_ITEMS then
      Exit;
    if (Res &lt;&gt; 0) then
      raise Exception(Res);
    P := PNetResourceArr(Buf);
    for I := 0 to Count - 1 do
    begin
      // Требуется копирование из буфера, так как он
      // действителен только до следующего вызова функций группы WNet
      New(TempRec);
      TempRec^.dwScope := P^.dwScope;
      TempRec^.dwType := P^.dwType ;
      TempRec^.dwDisplayType := P^.dwDisplayType ;
      TempRec^.dwUsage := P^.dwUsage ;
      {имеются ввиду вот эти указатели}
      TempRec^.LocalName := StrPas(P^.lpLocalName);
      {в смысле - строки PChar}
      TempRec^.RemoteName := StrPas(P^.lpRemoteName);
      TempRec^.Comment := StrPas(P^.lpComment);
      TempRec^.Provider := StrPas(P^.lpProvider);
      NetworkList.Add(TempRec);
      Inc(P);
    end;
    Res := WNetCloseEnum(lphEnum);
    {а следующий вызов - вот он!}
    if Res &lt;&gt; 0 then
      raise Exception(Res);
    Result:=NetWorkList;
  finally
    FreeMem(Buf);
  end;
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
