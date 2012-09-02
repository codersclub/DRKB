<h1>Перемещение иконок между несколькими TImageList</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
 var
   ico: TIcon;
 begin
   ico := TIcon.Create;
   try
     Imagelist1.GetIcon(0, ico); // Get first icon from Imagelist1 
     Imagelist2.AddIcon(ico); // Add the icon to Imagelist2 
  finally
     ico.Free;
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
