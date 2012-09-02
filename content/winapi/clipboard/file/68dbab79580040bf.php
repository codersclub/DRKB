<h1>Сохранение всего содержимого буфера обмена в файл</h1>
<div class="date">01.01.2007</div>


<p>Из рассылки "Мастера DELPHI. Новости мира компонент,..."</p>
<pre>
var FS:TFileStream;
procedure TForm1.bClearClick(Sender: TObject);
begin
OpenClipBoard(0);
EmptyClipboard;
CloseClipBoard;
end;
 
procedure TForm1.BSaveClick(Sender: TObject);
var CBF:Cardinal;
CBFList:TList;
i:Integer;
h:THandle;
p:Pointer;
CBBlockLength,Temp:Cardinal;
FS:TFileStream;
begin
if OpenClipBoard(0)then begin
CBFList:=TList.Create;
CBF:=0;
repeat
CBF:=EnumClipboardFormats(CBF);
if CBF&lt;&gt;0 then
CBFList.Add(pointer(CBF));
until CBF=0;
edit1.text:=IntToStr(CBFList.Count);
if CBFList.Count&gt;0 then begin
FS:=TFileStream.Create('e:\cp.dat',fmCreate);
Temp:=CBFList.Count;
FS.Write(Temp,SizeOf(Integer));
for i:=0 to CBFList.Count-1 do begin
h:=GetClipboardData(Cardinal(CBFList[i]));
if h&gt;0 then begin
CBBlockLength:=GlobalSize(h);
if h&gt;0 then begin
p:=GlobalLock(h);
if p &lt;&gt; nil then begin
Temp:=Cardinal(CBFList[i]);
FS.Write(Temp,SizeOf(Cardinal));
FS.Write(CBBlockLength,SizeOf(Cardinal));
FS.Write(p^,CBBlockLength);
end;
GlobalUnlock(h);
end;
end;
end;
FS.Free;
end;
CBFList.Free;
CloseClipBoard;
  end;
end;
 
procedure TForm1.bLoadClick(Sender: TObject);
var h:THandle;
p:Pointer;
CBF:Cardin!
al;
CBBlockLength:Cardinal;
i,CBCount:Integer;
FS:TFileStream;
begin
if OpenClipBoard(0)then begin
FS:=TFileStream.Create('e:\cp.dat',fmOpenRead);
if FS.Size=0 then Exit;
FS.Read(CBCount,sizeOf(Integer));
if CBCount=0 then Exit;
for i:=1 to CBCount do begin
FS.Read(CBF,SizeOf(Cardinal));
FS.Read(CBBlockLength,SizeOf(Cardinal));
h:=GlobalAlloc(GMEM_MOVEABLE or GMEM_SHARE or GMEM_ZEROINIT,CBBlockLength);
if h&gt;0 then begin
p:=GlobalLock(h);
if p=nil then
GlobalFree(h)
else begin
FS.Read(p^,CBBlockLength);
GlobalUnlock(h);
SetClipboardData(CBF,h);
end;
end;
end;
FS.Free;
CloseClipBoard;
end;
end;
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Сохранение буфера обмена в файл
 
Процедура позволяет сохранить содержимое буфера обмена в заданый файл.
 
Код процедуры был взят на сайте: http://www.delphiworld.narod.ru/
(http://www.delphiworld.narod.ru/base/clipbrd_to_file.html) адаптирован под мои нужды.
 
P.S. На всякий случай: я не претендую на авторство 
данного кода, я его просто привёл к виду, который мне больше подходил. 
В эту базу я его выложил исходя из предположения, что не каждый, 
кому понадобится такая процедура знает вышеуказанный адрес или 
обратится туда (сам долго искал иные способы).
 
Зависимости: стандартные модули
Автор:       Lucifer, _lucifer_@ukr.net
Copyright:   http://www.delphiworld.narod.ru/
Дата:        6 октября 2004 г.
********************************************** }
 
procedure SaveFromClipBoardTo(FileName: string);
var
 CBFList: TList;
 i: Integer;
 h: THandle;
 p: Pointer;
 
 CBBlockLength,
 Temp,
 CBF: Cardinal;
 
 FS: TFileStream;
begin
 if OpenClipBoard(0) then begin
  CBFList := TList.Create;
  CBF := 0;
  repeat
   CBF := EnumClipboardFormats(CBF);
   if CBF &lt;&gt; 0 then CBFList.Add(pointer(CBF));
  until CBF = 0;
 
  if CBFList.Count &gt; 0 then begin
   FS := TFileStream.Create(FileName, fmCreate);
   Temp := CBFList.Count;
   FS.Write(Temp, SizeOf(Integer));
   for i := 0 to CBFList.Count - 1 do begin
    h := GetClipboardData(Cardinal(CBFList[i]));
    if h &gt; 0 then begin
     CBBlockLength := GlobalSize(h);
     if h &gt; 0 then begin
      p := GlobalLock(h);
      if p &lt;&gt; nil then begin
       Temp := Cardinal(CBFList[i]);
       FS.Write(Temp, SizeOf(Cardinal));
       FS.Write(CBBlockLength, SizeOf(Cardinal));
       FS.Write(p^, CBBlockLength);
      end;
      GlobalUnlock(h);
     end;
    end;
   end;
   FS.Free;
  end;
  CBFList.Free;
  CloseClipBoard;
 end;
end;
</pre>

