<h1>Как переместить курсор в конец только что открытого файла, т.е. дописать текст в конец?</h1>
<div class="date">01.01.2007</div>

<p>Используем объект Selection. Объект Selection имеет поля Start и End. Эти поля имеют тип Integer и содержат номера символов начальной и конечной позиции выделенного текста. Если выделить весь документ, а затем считать значения этих полей, то сможем определить объем документа как количество символов. Если в поле Start объекта Selection записать значение из поля End этого же объекта, то курсор будет перемещен в конец документа. Используем это обстоятельство для перемещения курсора в конец документа. В Delphi это выглядит следующим образом:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>Function EndOfDoc:boolean;
begin
 EndOfDoc:=true;
 try
  W.ActiveDocument.Range.Select;
  W.Selection.Start:=W.Selection.End;
 except
  EndOfDoc:=false;
 end;
End;
</pre>
&nbsp;</p>

