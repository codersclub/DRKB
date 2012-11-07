<h1>Перехват нажатия на системные кнопки формы (закрытие, минимизация окна и т.д.)</h1>
<div class="date">01.01.2007</div>


<p>Перехват нажатия на системные кнопки формы (закрытие , минимизация окна и т.д.)</p>

<p>   Сообщение WM_SYSCOMMAND приходит перед выполнением соответствующей команды,</p>
<p>    что дает возможность переопределить код.</p>
<p>   Описание :</p>
<p>   WM_SYSCOMMAND</p>
<p>   uCmdType = wParam;        // type of system command requested</p>
<p>   xPos = LOWORD(lParam);    // horizontal postion, in screen coordinates</p>
<p>   yPos = HIWORD(lParam);    // vertical postion, in screen coordinates</p>

<p>   Например, перехват события минимизации окна приложения:</p>
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

