<h1>Печать содержимого TMemo / TListbox</h1>
<div class="date">01.01.2007</div>


<p>Как мне вывести на печать все строки компонента TMemo или TListbox?</p>
<p>Нижеприведенная функция в качестве параметра акцептует объект TStrings и распечатывает все строки на принтере, установленном в системе по умолчанию.Поскольку функция использует TStrings, то она может работать с любыми типами компонентов, имеющими свойство типа TStrings, например TDBMemo или TOutline.</p>

<pre>
uses Printers;
 
procedure PrintStrings(Strings: TStrings);
var
 
  Prn: TextFile;
  i: word;
begin
 
  AssignPrn(Prn);
  try
    Rewrite(Prn);
    try
      for i := 0 to Strings.Count - 1 do
        writeln(Prn, Strings.Strings[i]);
    finally
      CloseFile(Prn);
    end;
  except
    on EInOutError do
      MessageDlg('Ошибка печати текста.', mtError, [mbOk], 0);
  end;
end;
</pre>


<hr />Для печати содержимого TMemo или TListbox используйте следующий код:</p>

<p>PrintStrings(Memo1.Lines);</p>

<p>или</p>

<p>PrintStrings(Listbox1.Items);</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

