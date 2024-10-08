---
Title: Как программно двигать курсор мышки?
Date: 01.01.2007
---


Как программно двигать курсор мышки?
====================================

Вариант 1:

Source: <https://forum.sources.ru>

Следующий пример показывает, как "подтолкнуть мышку" без вмешательства
пользователя.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      pt : TPoint;
    begin
       Application.ProcessMessages;
       Screen.Cursor := CrHourglass;
       GetCursorPos(pt);
       SetCursorPos(pt.x + 1, pt.y + 1);
       Application.ProcessMessages;
       SetCursorPos(pt.x - 1, pt.y - 1);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    uses
      Windows;
     
    procedure PlaceMyMouse(Sender: TForm; X, Y: word);
    var
      MyPoint: TPoint;
    begin
      MyPoint := Sender.ClientToScreen(Point(X, Y));
      SetCursorPos(MyPoint.X, MyPoint.Y);
    end;


------------------------------------------------------------------------

Вариант 3:

Эта статья даёт вам возможность управлять положением курсора мыши.
Теперь вы сможете указывать пользователю, что именно он должен сделать,
и не позволять ему делать то, что вам не нравится. Ну, и, даже если вы
будете просто хаотично передвигать мышь, пользователь будет просто
беситься!..

Для начала мы научимся узнавать где находится курсор мыши, ведь в
зависимости от этого будем принимать решение. Это мы можем сделать с
помощью функции GetCursorPos(). В качестве параметра ей нужно указать
адрес структуры TPoint - это попросту точка. У объектов данного класса
есть два поля: X и Y, которые описывают непосредственно координаты
точки. Если функция выполнится успешно, она вернёт значение true, иначе
- false. Например, следующий пример сдвигает кнопку по её нажатию и
вместе с ней курсор мыши, чтобы по следующему нажатию щелчок мышью не
пришёлся на область, расположенную за пределами кнопки. Этот эффект
можно увидеть в программе 3D Studio MAX, на временной шкале, которая
позволяет передвигаться по кадрам фильма.

    procedure TForm1.Button6Click(Sender: TObject);
    var
      p: TPoint;
    begin
      if GetCursorPos(p)=true then
      begin
        SetCursorPos(p.X+5,p.Y);
        Button6.Left:=Button6.Left+5;
      end;
    end;

В этом примере так же используется функция SetCursorPos, которая задаёт
положение курсору мыши. Ей в скобках нужно указать два числовых значения
X и Y, которые определяют координаты нового положения курсора.

Я эту функцию использовал в одной из своих программ. Было это, когда я
писал About. На самом видном месте окна я установил метку-гиперссылку,
указав в её заголовке свой e-mail. Но почему-то мне показалось, что
этого не достаточно, чтобы привлечь внимание пользователя, тогда я
заставил указатель мыши перемещаться к этой метке, и "пальцем"
указывать на неё, в тот момент, когда мышь доползала до нужного места.
Не заметить мой e-mail было просто невозможно!!!

Для этого нужно сделать следующее:

- Поместите на форму компонент типа TLabel
- Вынесите компонент TTimer
- Объявите две глобальных переменные:

        var
          x_need, y_need: integer;

    именно в них мы будем отслеживать координаты нужной позиции для
    указателя мыши

- По событию формы OnActivate() активизируйте переменные:

        x_need := Label1.Left + Form1.Left + 20;
        y_need := Label1.Top + Form1.Top + 30;

- По событию OnTimer для компонента Timer напишите:

        procedure TForm1.Timer1Timer(Sender: TObject);
        var
          t: TPoint;
          changex, changey: integer;
        begin
          GetCursorPos(t);
          if t.y<>y_need then
          begin
            if t.Y>y_need then
              changey:=-1
            else
              changey:=1;
            SetCursorPos(t.X,t.Y+changey);
          end
          else
          begin
            if t.x<>x_need then
            begin
              if t.X>x_need then
                changex:=-1
              else
                changex:=1;
              SetCursorPos(t.X+changex,t.Y);
            end
            else
              Timer1.Enabled:=false;
          end;
        end;

- Скомпилируйте [F9] и убедитесь, что скорость движения слишком
маленькая - отрегулируйте её с помощью свойства Timer\'a Interval.
Значение этого свойства обратнопропорционально скорости движения
указателя мыши.
