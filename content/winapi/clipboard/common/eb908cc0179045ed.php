<h1>Копирование в буфер обмена</h1>
<div class="date">01.01.2007</div>


<pre>
procedure CopyButtonClick(Sender: TObject);
begin
  if ActiveControl is TMemo then
    TMemo(ActiveControl).CopyToClipboard;
  if ActiveControl is TDBMemo then
    TDBMemo(ActiveControl).CopyToClipboard;
  if ActiveControl is TEdit then
    TEdit(ActiveControl).CopyToClipboard;
  if ActiveControl is TDBedit then
    TDBedit(ActiveControl).CopyToClipboard;
end;
 
procedure PasteButtonClick(Sender: TObject);
begin
  if ActiveControl is TMemo then
    TMemo(ActiveControl).PasteFromClipboard;
  if ActiveControl is TDBMemo then
    TDBMemo(ActiveControl).PasteFromClipboard;
  if ActiveControl is TEdit then
    TEdit(ActiveControl).PasteFromClipboard;
  if ActiveControl is TDBedit then
    TDBedit(ActiveControl).PasteFromClipboard;
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
