<h1>Создание заставки при старте программы</h1>
<div class="date">01.01.2007</div>


<p>Перед появлением главного окна во всех серьёзных приложениях сначала появляется заставка. Теперь и у Вас есть возможность повыёживаться! Для создания заставки выполняем следующую последовательность действий:</p>

<p>Начинаем создание нового приложение командой "New Application" ("Новое приложение") из меню "File" ("Файл")</p>

<p>Добавьте ещё одну форму: "New Form"("Новая форма") из меню "File" ("Файл"). Это окно и будет заставкой. У него нужно убрать рамку с полосой заголовка, установив свойство "BorderStyle" в "bsNone". Теперь можно смело разработать дизайн окна заставки.</p>

<p>Из меню "Project" ("Проект") выбрать команду "Options"("Опции"). Зайти на закладку "Forms"("Формы") и Form2 из списка автоматически создаваемых форм (Auto-Create forms) перенести в список доступных форм (Available forms)</p>

<p>На форму-заставку с закладки System вынести компонент Timer. В его свойстве Interval установить значение 5000, а в событии OnTimer написать:</p>


<p>Timer1.Enabled := false;</p>


<p>Это сделано для того, чтобы заставка была видна в период указанного времени - 5000 миллисекунд, т.е. 5 секунд.</p>

<p>Перейти в файл проекта, нажав Ctrl+F12 и выбрав Project1. Исходный код должен выглядеть так:</p>

<pre>
program Project1;
 
uses
  Forms,
  Unit1 in 'Unit1.pas' {Form1},
  Unit2 in 'Unit2.pas' {Form2};
 
{$R *.RES}
 
begin
  Application.Initialize;
  Application.CreateForm(TForm1, Form1);
  Application.Run;
end.
</pre>



<p>Теперь мы внесём сюда немного изменений и код должен стать таким:</p>

<pre>
program Project1;
 
uses
  Forms,
  Unit1 in 'Unit1.pas' {Form1},
  Unit2 in 'Unit2.pas' {Form2};
 
{$R *.RES}
 
begin
  Application.Initialize;
  Form2 := TForm2.Create(Application);
  Form2.Show;
  Form2.Update;
  while Form2.Timer1.Enabled do
    Application.ProcessMessages;
  Application.CreateForm(TForm1, Form1);
  Form2.Hide;
  Form2.Free;
  Application.Run;
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
