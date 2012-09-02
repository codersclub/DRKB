<h1>Получение OpenGL расширений</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Получение OpenGL расширений
 
Зависимости: OpenGL
Автор:       Gua, gua@ukr.net, ICQ:141585495, Simferopol
Copyright:   Gua
Дата:        18 июля 2002 г.
***************************************************** }
 
function GetOGLExtensions: string;
var
  DC: HDC;
  hrc: HGLRC;
  {Установка формата пикселей}
  procedure SetDCPixelFormat;
  var
    DC: HDC;
    nPixelFormat: Integer;
    pfd: TPixelFormatDescriptor;
  begin
    FillChar(pfd, SizeOf(pfd), 0);
    nPixelFormat := ChoosePixelFormat(DC, @pfd);
    SetPixelFormat(DC, nPixelFormat, @pfd);
  end;
 
begin
  DC := GetDC(0);
  SetDCPixelFormat;
  hrc := wglCreateContext(DC);
  wglMakeCurrent(DC, hrc);
 
  Result := StrPas(PChar(glGetString(GL_EXTENSIONS)));
 
  wglMakeCurrent(0, 0);
  wglDeleteContext(hrc);
  ReleaseDC(0, DC);
  DeleteDC(DC);
end;
</pre>
<p>Пример использования: </p>
<pre>MessageDlg(GetOGLExtensions,mtInformation,[mbOK],0); 
</pre>


