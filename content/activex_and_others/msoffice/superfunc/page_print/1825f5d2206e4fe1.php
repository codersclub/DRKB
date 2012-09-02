<h1>Некоторые общие параметры для листа</h1>
<div class="date">01.01.2007</div>

<p>Некоторые общие параметры для листа</p>
Фоновый рисунок листа устанавливается процедурой SetBackgroundPicture, коллекции Sheets или объекта ActiveSheet. Если аргумент FileName этой функции равен пустой строке, то это отменяет установленный ранее фоновый рисунок. Реализация этой возможности на Delphi представлена в виде функции SetBackgroundPicture.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function SetBackgroundPicture(sheet:variant;
  file_:string):boolean;
begin
 SetBackgroundPicture:=true;
 try
  E.ActiveWorkbook.Sheets.Item
 &nbsp; [sheet].SetBackgroundPicture(FileName:=file_);
 except
  SetBackgroundPicture:=false;
 end;
End;
</pre>
&nbsp;</p>
Сетку активной страницы можно сделать видимой или невидимой, используя свойство DisplayGridlines объекта ActiveWindow. Если перед этим необходимо выбрать определенный лист, то используйте метод Select, например, Sheets("Лист1").Select.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function DisplayGridlines(display:boolean):boolean;
begin
 DisplayGridlines:=true;
 try
  E.ActiveWindow.DisplayGridlines:=display;
 except
  DisplayGridlines:=false;
 end;
End;
</pre>
&nbsp;</p>
