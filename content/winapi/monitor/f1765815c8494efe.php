<h1>Выключить монитор</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button3Click(Sender: TObject);
begin
  MessageDlg('Уже поздно. Будь послушным мальчиком. '+
  'Туши свет и вали спать!', mtInformatoion, [mbOk], 0);
  SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, 0);
end;
 
 
 
 
Для того, чтобы программно включить монитор можете использовать следующий код: 
 
 
 
procedure TForm1.Button3Click(Sender: TObject);
begin
  SendMessage(Application.Handle, WM_SYSCOMMAND, SC_MONITORPOWER, -1);
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

