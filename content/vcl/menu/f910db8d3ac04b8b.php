<h1>Как заставить системное меню выпасть в указанном месте?</h1>
<div class="date">01.01.2007</div>


<pre>
 
{
  How to popup the windows system menu?
  Maybe you can use Keybd_event to eumlate ALT+SPACE
  Maybe you can use a TPopupmenu.
  But they always have some problem.
  The method below is a perfect solution!
  BTW: if your form has borderstyle = bsNone, Please do it like this:
  Set forms style = bsSingle; and use the code below to set form boder:
  SetWindowLong(Handle, GWL_STYLE,GetWindowLong(Handle, GWL_STYLE)
  and (not WS_CAPTION) or WS_DLGFRAME or WS_OVERLAPPED);
}
 
 procedure TForm1.Button1Click(Sender: TObject);
 const
   { Undocument message ID }
   WM_POPUPSYSTEMMENU = $313;
 begin
   SendMessage(Handle, WM_POPUPSYSTEMMENU, 0,
   MakeLong(Mouse.CursorPos.X, Mouse.CursorPos.Y));
 end;
 
</pre>

