<h1>Преобразовать первую букву каждого слова к верхнему регистру в TEdit</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Edit1Change(Sender: TObject);
 var
   OldChange: TNotifyEvent;
   OldStart: Integer;
 begin
   with (Sender as TEdit) do
   begin
     OldChange := OnChange;
     OnChange  := nil;
     OldStart  := SelStart;
     if ((SelStart &gt; 0) and (Text[SelStart - 1] = ' ')) or (SelStart = 1) then
     begin
       SelStart  := SelStart - 1;
       SelLength := 1;
       SelText   := AnsiUpperCase(SelText);
     end;
 
     OnChange := OldChange;
     SelStart := OldStart;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
<hr />
<pre>
procedure TForm1.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  with Sender as TEdit do
    if (Text = '') or (Text[SelStart] = ' ')
      or (SelLength = Length(Text)) then
        if Key in ['a'..'z'] then
          Key := UpCase(Key);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

