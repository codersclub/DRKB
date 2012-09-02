<h1>Автоматический формат даты в компоненте TEdit</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Edit1Exit(Sender: TObject);
begin
  if Edit1.Text &lt;&gt; '' then
  begin
    try
      StrToDate(Edit1.Text);
    except
      Edit1.SetFocus;
      MessageBeep(0);
      raise Exception.Create('"' + Edit1.Text
        + '" - некорректная дата');
    end {try};
    Edit1.Text := DateToStr(StrToDate(Edit1.Text));
  end {if};
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
