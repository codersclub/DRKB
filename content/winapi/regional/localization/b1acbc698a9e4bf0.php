<h1>Как узнать, является ли окно Unicode?</h1>
<div class="date">01.01.2007</div>


<pre>
{
  The IsWindowUnicode function
  determines whether the specified window is a native Unicode window
 
  The character set of a window is determined by the use of the RegisterClass function.
  If the window class was registered with the ANSI version of RegisterClass (RegisterClassA),
  the character set of the window is ANSI. If the window class was registered with the Unicode
  version of RegisterClass (RegisterClassW), the character set of the window is Unicode.
 
  The system does automatic two-way translation (Unicode to ANSI) for window messages.
  For example, if an ANSI window message is sent to a window that uses the Unicode character set,
  the system translates that message into a Unicode message before calling the window procedure.
  The system calls IsWindowUnicode to determine whether to translate the message.
 
}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  {determine if the window is a Unicode window}
  if (IsWindowUnicode(Form1.Handle)) then
    Button1.Caption := 'This window is a Unicode window'
  else
    Button1.Caption := 'This window is not a Unicode window'
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
