<h1>Как получить иконку чужого окна?</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
First Start Notepad.exe and run this code: 
}
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   hwindow : THandle;
   H: HIcon;
 begin
   hwindow := FindWindow('notepad',nil);
   H := CopyIcon(GetClassLong(hwindow, GCL_HICON ));
   DrawIcon(Canvas.Handle, 30, 30, H);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
