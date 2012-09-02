<h1>Как изменить пароль для указанной сети или домена?</h1>
<div class="date">01.01.2007</div>


<pre>
function NetUserChangePassword(Domain: PWideChar; UserName: PWideChar; OldPassword: PWideChar;
  NewPassword: PWideChar): Longint; stdcall; external 'netapi32.dll'
  Name 'NetUserChangePassword';
 
// Changes a user's password for a specified network server or domain.
// Requirements:  Windows NT/2000/XP
// Windows 95/98/Me: You can use the PwdChangePassword function to change a user's
// Windows logon password on these platforms
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  NetUserChangePassword(PWideChar(WideString('\\COMPUTER')),
    PWideChar(WideString('username')),
    PWideChar(WideString('oldpass')),
    PWideChar(WideString('newpass')));
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
