<h1>Открытие MDI-окон определенного размера</h1>
<div class="date">01.01.2007</div>


<pre>
var
  ProjectWindow: TWndProject;
begin
  If ProjectActive=false then 
  begin
    LockWindowUpdate(ClientHandle);
    ProjectWindow:=TWndProject.Create(self);
    ProjectWindow.Left:=10;
    ProjectWindow.Top:=10;
    ProjectWindow.Width:=373;
    ProjecTwindow.Height:=222;
    ProjectWindow.Show;
    LockWindowUpdate(0);
  end;
end;
</pre>

<p>Используйте LockWindowUpdate перед созданием окна и после того, как создание будет завершено. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
