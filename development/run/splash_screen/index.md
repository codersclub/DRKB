---
Title: Создание заставки при старте программы
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Создание заставки при старте программы
======================================

Перед появлением главного окна во всех серьёзных приложениях сначала
появляется заставка. Теперь и у Вас есть возможность повыёживаться!
Для создания заставки выполняем следующую последовательность действий:

1. Начинаем создание нового приложение командой "New Application"
("Новое приложение") из меню "File" ("Файл")

2. Добавьте ещё одну форму: "New Form"("Новая форма") из меню "File"
("Файл"). Это окно и будет заставкой. У него нужно убрать рамку с
полосой заголовка, установив свойство "BorderStyle" в "bsNone".
Теперь можно смело разработать дизайн окна заставки.

3. Из меню "Project" ("Проект") выбрать команду "Options"("Опции").
Зайти на закладку "Forms"("Формы") и Form2 из списка автоматически
создаваемых форм (Auto-Create forms) перенести в список доступных форм
(Available forms)

4. На форму-заставку с закладки System вынести компонент Timer. В его
свойстве Interval установить значение 5000, а в событии OnTimer
написать:

        Timer1.Enabled := false;

    Это сделано для того, чтобы заставка была видна в период указанного
    времени - 5000 миллисекунд, т.е. 5 секунд.

5. Перейти в файл проекта, нажав Ctrl+F12 и выбрав Project1. Исходный код
должен выглядеть так:

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

Теперь мы внесём сюда немного изменений и код должен стать таким:

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

