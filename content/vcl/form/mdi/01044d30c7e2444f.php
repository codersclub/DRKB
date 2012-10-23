<h1>Как сделать родительское окно с фоновым рисунком в клиентской области?</h1>
<div class="date">01.01.2007</div>


<p>Для того чтобы сделать это выполните следующие шаги:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Создайте новый проект.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Установите FormStyle формы в fsMDIForm</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Разместите Image на форме и загрузите в него картинку.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Найдите { Private Declarations } в объявлении формы и добавьте следующие строки:</p>
<pre>
                FClientInstance : TFarProc; 
                 FPrevClientProc : TFarProc; 
                 procedure ClientWndProc(var Message: TMessage); 
</pre>

<p> &nbsp;&nbsp;&nbsp;&nbsp; Добавьте следующие строки в разделе implementation:</p>
<pre>
             procedure TMainForm.ClientWndProc(var Message: TMessage); 
             var 
               Dc : hDC; 
               Row : Integer; 
               Col : Integer; 
             begin 
               with Message do 
                 case Msg of 
                   WM_ERASEBKGND: 
                   begin 
                     Dc := TWMEraseBkGnd(Message).Dc; 
                     for Row := 0 to ClientHeight div Image1.Picture.Height do 
                       for Col := 0 to ClientWidth div Image1.Picture.Width do 
                         BitBlt(Dc, 
                            Col * Image1.Picture.Width, 
                            Row * Image1.Picture.Height, 
                            Image1.Picture.Width, 
                            Image1.Picture.Height, 
                            Image1.Picture.Bitmap.Canvas.Handle, 
                            0, 
                            0, 
                            SRCCOPY); 
                       Result := 1; 
                   end; 
                   else 
                     Result := CallWindowProc(FPrevClientProc, 
                                              ClientHandle, 
                                              Msg, 
                                              wParam, 
                                              lParam); 
               end; 
             end; 
</pre>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В методе формы OnCreate добавьте:</p>
<pre>
                FClientInstance := MakeObjectInstance(ClientWndProc); 
                FPrevClientProc := Pointer(GetWindowLong(ClientHandle, 
                                           GWL_WNDPROC)); 
                SetWindowLong(ClientHandle, 
                              GWL_WNDPROC, LongInt(FClientInstance));  
</pre>

<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Добавьте к проекту новую форму и установите ее свойство FormStyle в</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fsMDIChild.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; У Вас получился  MDI-проект с "обоями" в клиентской области MDI формы.</p>
