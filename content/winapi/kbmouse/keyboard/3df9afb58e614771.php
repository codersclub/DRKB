<h1>Как определить нажатие определенной клавиши во время загрузки приложения?</h1>
<div class="date">01.01.2007</div>


<p>Используйту WinAPI функцию GetKeyState() для определения нажатия клавиши в тексте проекта. Для того чтобы увидеть текст файла проекта в главном меню Delphi 3 выберите "View"&gt;&gt;"ProjectSource" в Delphi 4 "Project"&gt;&gt;"View Source". <br>
<p>&nbsp;</p>
<pre>
             program Project1; 
 
             uses 
               Windows, 
               Forms, 
               Unit1 in 'Unit1.pas' {Form1}; 
 
             {$R *.RES} 
 
             begin 
               if GetKeyState(vk_F8) &lt; 1 then 
                MessageBox(0, 'F8 was pressed during startup', 'MyApp', mb_ok); 
               Application.Initialize; 
               Application.CreateForm(TForm1, Form1); 
               Application.Run; 
             end. 
</pre>

