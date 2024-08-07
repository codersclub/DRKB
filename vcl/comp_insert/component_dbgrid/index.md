---
Title: Помещение компонентов в TDBGrid
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Помещение компонентов в TDBGrid
===============================

Данный совет и сопутствующий код показывает как просто поместить любой
компонент в ячейку сетки данных. Компонент в данном контексте может
означать любой видимый элемент управления - от простого combobox до
сложного диалогового окна. Методы, описанные ниже, применимы практически
к любому визуальному компоненту. Если Вы можете поместить его на форму,
то, вероятно, сможете поместить и в ячейку DBGrid.

Здесь нет новых идей, фактически основная технология работы заключается
в имитации-трансплантации внешних компонентов в DBGrid. Идея в том,
чтобы получить контроль над табличной сеткой. Практически DBGrid состоит
из набора компонентов TDBEdit. Вводя данные в ячейку, вы работаете
непосредственно с TDBEdit. Остальные без фокуса ячейки в данный момент
реально являются статичной картинкой. В данном совете Вы узнаете как
поместить в сфокусированную ячейку другой, отличный от TDBEdit,
визуальный компонент.

**КОМПОНЕНТ #1 - TDBLOOKUPCOMBO**

Вам нужна форма с компонентом DBGrid на ней. Создайте новый проект и
поместите на основную форму DBGrid.

Далее поместите на форму TTable, установите псевдоним (Alias) в DBDEMOS,
TableName в GRIDDATA.DB и присвойте свойству Active значение True.
Поместите DataSource и сошлитесь в свойстве DataSet на Table1. Вернитесь
к DBGrid и укажите в свойстве DataSource компонент DataSource1. Данные
из GRIDDATA.DB должные появиться в табличной сетке...

Первый элемент, который мы собираемся поместить в DBGrid -
TDBLookupCombo, т.к. нам нужна вторая таблица для поиска. Поместите
второй TTable на форму. Установите псевдоним (Alias) в DBDEMOS,
TableName в CUSTOMER.DB и присвойте свойству Active значение True.
Поместите второй DataSource и сошлитесь в свойстве DataSet на Table2.

Теперь нужно поместить компонент TDBLookupCombo из палитры Data Controls
на любое место формы - это не имеет никакого значения, т.к. он обычно
будет невидим или будет нами имплантирован в табличную сетку. Установите
свойства компонента LookuoCombo следующим образом:

    DataSource      DataSource1
    DataField       CustNo
    LookupSource    DataSource2
    LookupField     CustNo
    LookupDisplay   CustNo  {Вы можете изменить это на Company позже,
                            но сейчас пусть это будет CustNo)

Пока мы только настроили компоненты. Теперь давайте создадим некоторый
код.

Первое, что Вам необходимо - сделать так, чтобы DBLookupCombo, который
Вы поместили на форму, во время запуска приложения оставался невидимым.
Для этого выберите Form1 в инспекторе объектов, перейдите на закладку
Events (события) и дважды щелкните на событии onCreate. Delphi
немедленно сгенерит и отобразит скелет кода будущего обработчика события
onCreate:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
     
    end;

Присвойте свойству Visible значение False в LookupCombo следующим
образом:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DBLookupCombo1.Visible := False;
    end;

Наверняка многим стало интересно, почему я не воспользовался инспектором
объектов для изменения свойств компонента. Действительно, можно было бы
и так. Лично я таким способом инициализирую компоненты, чьи свойства
могут изменяться во время работы приложения. Я изменил статическое
свойство, которое не отображается во время проектирования (если
воспользоваться инспектором объктов). Я думаю это делает код легче для
понимания.

Теперь нам необходимо "прикрутить" компонент к нашей табличной сетке.
Наша задача - автоматически отобразить DBLookupCombo в ячейке во время
получения ею фокуса (или перемещении курсора). Для этого необходимо
написать код для обработчиков двух событий: OnDrawDataCell и OnColExit.
Первым делом обработаем событие OnDrawDataCell. Дважды щелкните на
строчке OnDrawDataCell в инспекторе объектов и введите следующий код:

    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect: TRect;
      Field: TField; State: TGridDrawState);
    begin
      if (gdFocused in State) then
      begin
        if (Field.FieldName = DBLookupCombo1.DataField) then
        begin
          DBLookupCombo1.Left := Rect.Left + DBGrid1.Left;
          DBLookupCombo1.Top := Rect.Top + DBGrid1.top;
          DBLookupCombo1.Width := Rect.Right - Rect.Left;
          { DBLookupCombo1.Height := Rect.Bottom - Rect.Top; }
          DBLookupCombo1.Visible := True;
        end;
      end;
    end;

Причины чрезмерного использования конструкций begin/end скоро станут
понятны. В коде "говорится", что если параметр State имеет значение
gdFocused, то данная ячейка имеет фокус (в любой момент времени только
одна ячейка в табличной сетке может иметь фокус). Далее: если это
выделенная ячейка и ячейка имеет тоже имя поля как и поле данных
DBLookupCombo, DBLookupCombo необходимо поместить над этой ячейкой и
сделать его видимым. Обратите внимание на определение позиции
DBLookupCombo: она определяется относительно формы, а не ячейки. Так,
например, положение левой стороны LookupCombo должно учитывать положение
сетки (DBGrid1.Left) плюс положение соответствующей ячейки относительно
сетки (Rect.Left).

Также обратите внимание на то, что определение высоты LookupCombo в коде
закомментарено. Причина в том, что LookupCombo имеет минимальную высоту.
Вы просто не сможете сделать ее меньше. Минимальная высота LookupCombo
больше высоты ячейки. Если Вы раскомментарили строку, касающуюся высоты
LookupCombo, Ваш код изменит размер компонента и Delphi немедленно его
перерисует. Это вызовет неприятное моргание компонента. Бороться с этим
невозможно. Позвольте, чтобы LookupCombo был немного больше, чем ячейка.
Это выглядит немного странным, но это работает.

Теперь ради шутки запустите программу. Заработала? Сразу после запуска
переместите курсор на одну из ячеек табличной сетки. Вы ожидали чего-то
большего? Да! Мы только в середине пути. Теперь нам нужно спрятать
LookupCombo при покидании курсором колонки. Напишем обработчик события
onColExit. Это должно выглядеть примерно так:

    procedure TForm1.DBGrid1ColExit(Sender: TObject);
    begin
      If DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField then
        DBLookupCombo1.Visible := false;
    end;

Код использует свойство TDBGrids SelectedField для ассоциации имени поля
ячейки (FieldName) с нашим LookupCombo. Код "говорит": "Если ячейка
была в колонке с DBLookupCombo (имя поля ячейки совпадает с именем поля
DBLookupCombo), его необходимо сделать невидимым".

Теперь снова запустите приложение. Чувствуете эффект?

Теперь вроде бы все правильно, но мы забыли об одной вещи. Попробуйте
ввести новое значение в одно из LookupCombo. Проблема в том, что нажатие
клавиши обрабатывает DBGrid, а не LookupCombo. Чтобы исправить это, нам
нужно написать для табличной сетки обработчик события onKeyPress. Это
должно выглядеть примерно так:

    procedure TForm1.DBGrid1KeyPress(Sender: TObject; var Key: Char);
    begin
      if (key <> chr(9)) then
      begin
        if (DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField) then
        begin
          DBLookupCombo1.SetFocus;
          SendMessage(DBLookupCombo1.Handle, WM_Char, word(Key), 0);
        end;
      end;
    end;

В данном коде "говорится": если нажатая клавиша не является клавишей
Tab (Chr(9)) и текущее поле в табличной сетке LookupCombo, тогда
установите фокус на LookupCombo и передайте сообщение с кодом нажатой
клавиши LookupCombo. Здесь я воспользовался WIN API функцией. Вам не
нужно знать как это работает, достаточно того, что это просто работает.

Небольшое пояснение я все же дам. Для того, чтобы функция Window
SendMessage послала сообщение "куда надо", ей в качестве параметра
необходим дескриптор ("адрес") нужного компонента. Используйте
свойство компонента Handle. Затем нужно сообщить компоненту что мы от
него хотим. В нашем случае это Windows-сообщение WM\_CHAR, извещающее
LookupCombo о том, что ему посылается символ. Наконец, мы передаем ему
сам символ нажатой клавиши - word(Key). Word(key) - приведение к типу
word параметра Key события нажатия клавиши. Все достаточно просто,
правда? Все, что Вам действительно необходимо сделать - заменить имя
DBLookupCombo1 нашего вымышленного компонента на имя реального
компонента, который будет участвовать в "модернизации" табличной
сетки. Более подробную информацию о функции SendMessage Вы можете
почерпнуть из электронной справки, поставляемой вместе с Delphi.

Запустите снова Ваше приложение и попробуйте что-нибудь ввести. Это
работает! Экспериментируя, Вы увидите что с помощью клавиши Tab Вы
можете перейти из режима редактирования в режим перемещения курсора и
наоборот.

Теперь перейдите к инспектору объектов и измнените у компонента
DBLookupCombo свойство LookupDIsplay на Company. Снова запустите. Это
то, что Вы ожидали?

**КОМПОНЕНТ #2 - TDBCOMBO**

Здесь я не собираюсь обсуждать технологию имплантации DBCombo, так как
она практически не отличается от той, что была показана выше. Все
написанное в пункте #1 имеет силу и здесь. Вот пошагово разработанный
код для вашего компонента.

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DBLookupCombo1.Visible := False;
      DBComboBox1.Visible := False;
    end;
     
    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect: TRect;
      Field: TField; State: TGridDrawState);
    begin
      if (gdFocused in State) then
      begin
        if (Field.FieldName = DBLookupCombo1.DataField) then
        begin
          DBLookupCombo1.Left := Rect.Left + DBGrid1.Left;
          DBLookupCombo1.Top := Rect.Top + DBGrid1.top;
          DBLookupCombo1.Width := Rect.Right - Rect.Left;
          DBLookupCombo1.Visible := True;
        end
        else if (Field.FieldName = DBComboBox1.DataField) then
        begin
          DBComboBox1.Left := Rect.Left + DBGrid1.Left;
          DBComboBox1.Top := Rect.Top + DBGrid1.top;
          DBComboBox1.Width := Rect.Right - Rect.Left;
          DBComboBox1.Visible := True;
        end
      end;
    end;
     
    procedure TForm1.DBGrid1ColExit(Sender: TObject);
    begin
      if DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField then
        DBLookupCombo1.Visible := false
      else if DBGrid1.SelectedField.FieldName = DBComboBox1.DataField then
        DBComboBox1.Visible := false;
    end;
     
    procedure TForm1.DBGrid1KeyPress(Sender: TObject; var Key: Char);
    begin
      if (key <> chr(9)) then
      begin
        if (DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField) then
        begin
          DBLookupCombo1.SetFocus;
          SendMessage(DBLookupCombo1.Handle, WM_Char, word(Key), 0);
        end
        else if (DBGrid1.SelectedField.FieldName = DBComboBox1.DataField) then
        begin
          DBComboBox1.SetFocus;
          SendMessage(DBComboBox1.Handle, WM_Char, word(Key), 0);
        end;
      end;
    end;

**КОМПОНЕНТ #3 - TDBCHECKBOX**

Технология работы с компонентом DBCheckBox более интересна. В этом
случае нам необходимо дать понять пользователю о наличие компонента
DBCheckBox в ячейках без фокуса. Вы можете вставлять статическое
изображение компонента или динамически изменять изображение в
зависимости от логического состояния элемента управления. Я выбрал
второе. Я создал два BMP-файла - включенный (TRUE.BMP) и выключенный
(FALSE.BMP) DBCheckBox. Поместите два компонента TImage на форму,
присвойте им имена ImageTrue и ImageFalse и назначьте соответствующие
BMP-файлы в свойстве Picture. Да, чуть не забыл: Вам также необходимо
поместить на форму два компонента DBCheckbox. Установите набор данных
обоих компонентов в DataSource1 и присвойстве свойству Color значение
clWindow. Для начала создадим для формы обработчик события onCreate:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DBLookupCombo1.Visible := False;
      DBCheckBox1.Visible := False;
      DBComboBox1.Visible := False;
      ImageTrue.Visible := False;
      ImageFalse.Visible := False;
    end;

Теперь нам нужен обработчик события onDrawDataCell чтобы делать что-то с
ячейками, не имеющими фокуса. Здесь подойдет следующий код:

    procedure TForm1.DBGrid1DrawDataCell(Sender: TObject; const Rect: TRect;
      Field: TField; State: TGridDrawState);
    begin
      if (gdFocused in State) then
      begin
        if (Field.FieldName = DBLookupCombo1.DataField) then
        begin
          // ...СМОТРИ ВЫШЕ
        end
        else if (Field.FieldName = DBCheckBox1.DataField) then
        begin
          DBCheckBox1.Left := Rect.Left + DBGrid1.Left + 1;
          DBCheckBox1.Top := Rect.Top + DBGrid1.top + 1;
          DBCheckBox1.Width := Rect.Right - Rect.Left { - 1};
          DBCheckBox1.Height := Rect.Bottom - Rect.Top { - 1};
          DBCheckBox1.Visible := True;
        end
        else if (Field.FieldName = DBComboBox1.DataField) then
        begin
          // ...СМОТРИ ВЫШЕ
        end
      end
      else {в этом месте помещаем статическое изображение компонента}
      begin
        if (Field.FieldName = DBCheckBox1.DataField) then
        begin
          if TableGridDataCheckBox.AsBoolean then
            DBGrid1.Canvas.Draw(Rect.Left, Rect.Top, ImageTrue.Picture.Bitmap)
          else
            DBGrid1.Canvas.Draw(Rect.Left, Rect.Top, ImageFalse.Picture.Bitmap)
        end
      end;
    end;

Самое интересное место - последний участок кода. Он выполняется в
случае, когда состояние не равно gdFocused и сам CheckBox находится в
колонке. В нем осуществляется проверка данных поля: если они равны True,
то выводится рисунок TRUE.BMP, в противном случае - FALSE.BMP.
Предварительно я создал два изображения, представляющие собой "слепок"
двух логических состояния компонента, теперь будет очень трудно
обнаружить отсутствие компонента в ячейках с фокусом и без оного. Теперь
напишем обработчик события onColExit:

    procedure TForm1.DBGrid1ColExit(Sender: TObject);
    begin
      If DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField then
        DBLookupCombo1.Visible := false
      else
      If DBGrid1.SelectedField.FieldName = DBCheckBox1.DataField then
        DBCheckBox1.Visible := false
      else
      If DBGrid1.SelectedField.FieldName = DBComboBox1.DataField then
        DBComboBox1.Visible := false;
    end;

Организуйте обработку события onKeyPress как показано ниже:

    procedure TForm1.DBGrid1KeyPress(Sender: TObject; var Key: Char);
    begin
      if (key <> chr(9)) then
      begin
        if (DBGrid1.SelectedField.FieldName = DBLookupCombo1.DataField) then
        begin
          DBLookupCombo1.SetFocus;
          SendMessage(DBLookupCombo1.Handle, WM_Char, word(Key), 0);
        end
        else if (DBGrid1.SelectedField.FieldName = DBCheckBox1.DataField) then
        begin
          DBCheckBox1.SetFocus;
          SendMessage(DBCheckBox1.Handle, WM_Char, word(Key), 0);
        end
        else if (DBGrid1.SelectedField.FieldName = DBComboBox1.DataField) then
        begin
          DBComboBox1.SetFocus;
          SendMessage(DBComboBox1.Handle, WM_Char, word(Key), 0);
        end;
      end;
    end;

Наконец, последняя хитрость. Для удобства пользователя заголовку
компонента нужно присвоить текущее логическое значение. С самого начала
у меня была идея поручить это обработчику события onChange, но проблема
в том, что событие может возникнуть неединожды. Итак, я должен снова
воспользоваться функцией Windows API и послать компоненту
соответствующее значение: "SendMessage(DBCheckBox1.Handle,
BM\_GetCheck, 0, 0)", которая возвращает 0 в случае если компонент
невключен и любое другое число в противном случае.

    procedure TForm1.DBCheckBox1Click(Sender: TObject);
    begin
      if SendMessage(DBCheckBox1.Handle, BM_GetCheck, 0, 0) = 0 then
        DBCheckBox1.Caption := ' ' + 'Ложь'
      else
        DBCheckBox1.Caption := ' ' + 'Истина'
    end;

Это все. Надеюсь, Вы узнали для себя что-то новое. Я пробовал данную
технологию с диалоговыми окнами. Делается достаточно просто и
великолепно работает. Радует простота реализации. Вам даже не нужно
знать как это работает, единственное, что Вам придется - заменить в
тексте кода имена вымышленных компонентов на те, которые Вы реально
хотите отображать в табличной сетке.

**Ревизия**

Вышеприведенный код оказался несвободным от недостатков - после первой
публикации совета дотошные программисты таки обнаружили две значительные
недоработки. Первая проблема - если компонент имеет фокус, то для
перемещения на следующую ячейку необходимо двукратное нажатие клавиши
Tab. Вторая проблема возникает при добавлении новой записи.

**Проблема # 1 - Необходимость двойного нажатия клавиши Tab.**

Действительно, компонент, используемый для имплантации существует сам по
себе, а не является частью табличной сетки. В случае, когда DBGrid имеет
фокус, то для перемещения на следующую ячейку необходимо двукратное
нажатие клавиши Tab. Первое нажатие клавиши перемещает фокус из
имплантированного компонента на текущую ячейку, находящуюся под этим
компонентом, и только второе нажатие клавиши Tab перемещает нас в
следующую ячейку. Попробуем это исправить.

Для начала в форме, содержащей табличную сетку, опишем логическую
переменную WasInFloater следующим образом:

    type
     
    TForm1 = class(TForm)
    ...
    ...
    private
    { Private declarations }
    WasInFloater : Boolean;
    ...
    ...
    end;

Затем для компонента LookupCombo напишем обработчик события onEnter, где
присвоим переменной WasInFloater значение True. Это позволит нам понять
где в данный момент находится фокус.

    procedure TForm1.DBLookupCombo1Enter(Sender: TObject);
    begin
      WasInFloater := True;
    end;

И, наконец, создаем хитрый обработчик события onKeyUp, позволяющий
исправить досадный недостаток.

    procedure TForm1.DBGrid1KeyUp(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      if (Key in [VK_TAB]) and WasInFloater then
      begin
        SendMessage(DBGrid1.Handle, WM_KeyDown, Key, 0);
        WasInFloater := False;
      end;
    end;

Данный код реагирует на нажатие клавиши и позволяет в случае, когда
фокус передался из имплантированного элемента управления табличной
сетеке, вторично эмулировать нажатие клавиши Tab (передается код нажатой
клавиши, т.е. Tab). Это работает как для отдельной клавиши Tab, так и
для комбинации Shift-Tab.

**Проблема #2 - Новая запись исчезает, когда компонент получает фокус.**

Вторая проблема - в случае, когда вы нажимаете в навигаторе кнопку
"добавить", запись добавляется, но, когда Вы после щелкаете на одном
из компонентов, имплантированных в табличную сетку, новая запись
таинственным образом исчезает. Причина этого - странный флаг
dgCancelOnExit в опциях DBGrid, который имеет значение True по
умолчанию. Установите это в False и вышеназванная проблема исчезает.

По-моему, Borland неправильно поступил, назначив такое значение по
умолчанию, флаг должен иметь значение False. Я все время сталкиваюсь с
данной проблемой, да и не только я, судя по новостным конференциям.
Данная опция действует в случае потери компонентом фокуса и отменяет
последние результаты редактирования. Во всяком случае во всех моих
проектах я первым делом сбрасываю данный флаг.

