<h1>Создать MDI-окно с координатами (0, 0)</h1>
<div class="date">01.01.2007</div>


<pre>procedure TFormX.FormCreate(Sender: TObject);
 Var
   r: TRect;
   client: HWND;
 Begin
   client := application.mainform.clienthandle;
   Windows.GetClientRect( client, r );
   MapWindowPoints( client, HWND_DESKTOP, r, 2 );
   BoundsRect := r;
 End;
</pre>

