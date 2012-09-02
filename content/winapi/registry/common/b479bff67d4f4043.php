<h1>Удобная загрузка местоположения формы</h1>
<div class="date">01.01.2007</div>

Автор: Virtualik </p>
<p>Если вы храните параметры местоположения(Top, Left, Width, Height) формы в реестре, то чтобы не загружать данные из нескольких ключей вы можете их записать в один, и из одного же прочитать ;) </p>
<p>По сути, данные записывается в виде record'а. А как это примерно может выглядеть смотрите в примере.</p>
<pre>var
  Ini: TRegIniFile;
...
 
procedure TForm1.FormCreate(Sender: TObject);
var
  Rct: TRect;
begin
  Ini := TRegIniFile.Create('&lt;Здесь вы пишете путь к вашим настройкам в
    реестре &gt; ');
  // Если есть данные --&gt; загружаем их
  if Ini.ReadBinaryData('FormPosition', Rct, SizeOf(TRect)) &gt; 0 then
    BoundsRect := Rct;
  ...
end;
 
procedure TReply.FormDestroy(Sender: TObject);
var
  Rct: TRect;
begin
  // Сохранение данных на выходе
  ...
  Rct := BoundsRect;
  Ini.WriteBinaryData('MsgPos', Rct, SizeOf(TRect));
  Ini.Free;
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

