<h1>Перехват нажатия на системные кнопки формы (закрытие, минимизация окна и т.д.)</h1>
<div class="date">01.01.2007</div>


<p>Перехват нажатия на системные кнопки формы (закрытие , минимизация окна и т.д.)</p>

<p> &nbsp; Сообщение WM_SYSCOMMAND приходит перед выполнением соответствующей команды,</p>
<p> &nbsp;&nbsp; что дает возможность переопределить код.</p>
<p> &nbsp; Описание :</p>
<p> &nbsp; WM_SYSCOMMAND</p>
<p> &nbsp; uCmdType = wParam;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; // type of system command requested</p>
<p> &nbsp; xPos = LOWORD(lParam);&nbsp;&nbsp;&nbsp; // horizontal postion, in screen coordinates</p>
<p> &nbsp; yPos = HIWORD(lParam);&nbsp;&nbsp;&nbsp; // vertical postion, in screen coordinates</p>

<p> &nbsp; Например, перехват события минимизации окна приложения:</p>
<pre>
   Type TMain = class(TForm)
     ....
    protected
      Procedure WMGetSysCommand(var Message : TMessage); message WM_SYSCOMMAND;
    end;
   .....
   //----------------------------------------------------------------
   //   Обработка сообщения WM_SYSCOMMAND (перехват минимизации окна)
   //----------------------------------------------------------------
   Procedure TMain.WMGetSysCommand(var Message : TMessage) ;
   Begin
        IF (Message..wParam = SC_MINIMIZE)  
        Then Main.Visible:=False
        Else Inherited;
   End;
</pre>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>

