---
Title: Симфония на клавиатуре (статья)
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Симфония на клавиатуре (статья)
===============================

_Перевод одноимённой статьи с сайта delphi.about.com )_

Начиная с самого рассвета компьютерной промышленности, клавиатура была
первичным устройством ввода информации, и вероятнее всего сохранит свою
позицию ещё долгое время.

События клавиатуры, наряду с событиями мыши, являются основными
элементами взаимодействия пользователя с программой. В данной статье
пойдёт речь о трёх событиях, которые позволяют отлавливать нажатия
клавиш в приложении Delphi: OnKeyDown, OnKeyUp и OnKeyPress.

Для получения ввода с клавиатуры, приложения Delphi могут использовать
два метода. Самый простой способ, это воспользоваться одним из
компонентов, автоматически реагирущем на нажатия клавиш, таким как Edit.
Второй способ заключается в создании процедур в форме, которые будут
обрабатывать нажатия и отпускания клавиш. Эти обработчики могут
обрабатывать как нажатия одиночных клавиш, так и комбинаций. Итак, вот
эти события:

OnKeyDown - вызывается, когда на клавиатуре нажимается любая клавиша.
OnKeyUp - вызывается, когда любая клавиша на клавиатуре отпускается.
OnKeyPress - вызывается, когда нажимается клавиша, отвечающая за
определённый ASCII символ.

Теперь самое время посмотреть, как выглядят в программе заголовки
обработчиков:

    procedure TForm1.FormKeyDown
    (Sender: TObject; var Key: Word; Shift: TShiftState);
    ...
    procedure TForm1.FormKeyUp
    (Sender: TObject; var Key: Word; Shift: TShiftState);
    ...
    procedure TForm1.FormKeyPress
    (Sender: TObject; var Key: Char);

Все события имеют один общий параметр, обычно называемый Key. Этот
параметр используется для передачи кода нажатой клавиши. Параметр Shift
(в процедурах OnKeyDown и OnKeyUp), указывает на то, была ли нажата
клавиша в сочетании с Shift, Alt, и Ctrl.

**Фокус**

Фокус, это способность получать пользовательский ввод через мышь или
клавиатуру. Получать события от клавиатуры могут только те объекты,
которые имеют фокус. На форме активного приложения в один момент времени
может быть активным (иметь фокус) только один компонент.

Некоторые компоненты, такие как TImage, TPaintBox, TPanel и TLabel не
могут получать фокус, другими словами, это компоненты, наследованные от
TGraphicControl. Так же не могут получать фокус невидимые компоненты,
такие как TTimer.

**OnKeyDown, OnKeyUp**

События OnKeyDown и OnKeyUp обеспечивают самый низкий уровень ответа
клавиатуры. Обработчики OnKeyDown и OnKeyUp могут реагировать на все
клавиши клавиатуры, включая функциональные и комбинации с клавишами
Shift, Alt, и Ctrl.

События клавиатуры - не взаимоисключающие. Когда пользователь нажимает
клавишу, то генерируются два события OnKeyDown и OnKeyPress, а когда
отпускает, то только одно: OnKeyUp. Если пользователь нажмёт одну из
клавиш, которую OnKeyPress не сможет определить, то будет сгенерировано
только одно событие OnKeyDown, а при отпускании OnKeyUp.

**OnKeyPress**

OnKeyPress возвращает различные значения ASCII для \'g\' и \'G,\'.
Однако, OnKeyDown и OnKeyUp не делают различия между верхним и нижним
регистром.

**Параметры Key и Shift**

Параметр Key можно изменять, чтобы приложение получило другой код
нажатой клавиши. Таким образом можно ограничивать набор различных
символов, которые пользователь может ввести с клавиатуры. Например
разрешить вводить только цифры. Для этого добавьте в обработчик события
OnKeyPress следующий код и установите KeyPreview в True (см. ниже).

    if Key in ['a'..'z'] + ['A'..'Z'] then Key:=#0

Это выражение проверяет, содержит ли параметр Key символы нижнего
регистра (\'a\'..\'z\') и символы верхнего регистра (\'A\'..\'Z\'). Если
так, то в параметр заносится значение нуля, чтобы предотвратить ввод в
компонент Edit (например).

В Windows определены специальные константы для каждой клавиши. Например,
VK\_RIGHT соответствует коду клавиши для правой стрелки.

Чтобы получить состояния специальных клавиш, таких как TAB или PageUp
можно воспользоваться API функцией GetKeyState. Клавиши состояния могут
находиться в трёх состояниях: отпущена, нажата, и включена. Если старший
бит равен 1, то клавиша нажата, иначе отпущена. Для проверки этого бита
можно воспользоваться API функцией HiWord. Если младший бит равен 1, то
клавиша включена. Вот пример получения сосотояния специальной клавиши:

    if HiWord(GetKeyState(vk_PageUp)) <> 0 then
      ShowMessage('PageUp - DOWN')
    else
      ShowMessage('PageUp - UP');

В событиях OnKeyDown и OnKeyUp, Key является беззнаковым двухбайтовым
(Word) значением, которое представляет виртуальную клавишу Windows. Для
получания значения символа можно воспользоваться функцией Chr. В событии
OnKeyPress параметр Key является значением Char, которое представляет
символ ASCII.

События OnKeyDown и OnKeyUp имеют параметр Shift с типом TShiftState. В
Delphi тип TShiftState определён как набор флагов, определяющих
состояние Alt, Ctrl, и Shift при нажатии клавиши.

Например, следующий код (из обработчика OnKeyUp) соединяет строку \'Ctrl
+\' с нажатой клавишей и отображает результат в заголовке формы:

    if ssCtrl in Shift then
      Form1.Caption:= 'Ctrl +' + Chr(Key);

Если нажать Ctrl + A, то будут сгенерированы следующие события:

    KeyDown (Ctrl) // ssCtrl
    KeyDown (Ctrl+A) //ssCtrl + 'A'
    KeyPress (A)
    KeyUp (Ctrl+A)

**Переадресация событий клавиатуры в форму**

Клавиатурный обработчик может работать на двух уровнях: на уровне
компонентов и на уровне формы. Свойство формы KeyPreview определяет,
будут ли клавиатурные события формы вызываться перед клавиатурными
событиями компонентов, так как форма может получать все нажатия клавиш,
предназначенные для компонента имеющего в данный момент фокус.

Чтобы перехватить нажатия клавиш на уровне формы, до того как они будут
переданы компонентам на форме, необходимо установить свойство KeyPreview
в True. После этого компонент как и раньше будет получать события,
однако сперва они будут попадать в форму, чтобы дать возможность
программе разрешить или запретить ввод различных символов.

Допустим, У Вас на форме есть несколько компонентов Edit и процедура
Form.OnKeyPress выглядит следующим образом:

    procedure TForm1.FormKeyPress(Sender: TObject; var Key: Char);
    begin
      if Key in ['0'..'9'] then Key := #0
    end;

Если один из компонентов Edit имеет фокус и свойство KeyPreview
установлено в False, то этот код не будет выполнен - другими словами,
если пользователь нажмёт клавишу \'5\', то в компоненте Edit, имеющем
фокус, появится символ "5".

Однако, если KeyPreview установлено в True, то событие формы OnKeyPress
будет выполнено до того, как компонент Edit увидит нажатую клавишу.
Поэтому, если пользователь нажмёт клавишу \'5\', то в Key будет
подставлено нулевое значение, предотвращая тем самым попадание числовых
символов в Edit.

ПРИЛОЖЕНИЕ: Таблица кодов виртуальных клавиш.

Symbolic constant name | Value (hexadecimal) | Keyboard (or mouse) equivalent
--------------|----------------|------------------------------------------
VK_LBUTTON    | 01             | Left mouse button
VK_RBUTTON    | 02             | Right mouse button
VK_CANCEL     | 03             | Control-break processing
VK_MBUTTON    | 04             | Middle mouse button (three-button mouse)
VK_BACK       | 08             | BACKSPACE key
VK_TAB        | 09             | TAB key
VK_CLEAR      | 0C             | CLEAR key
VK_RETURN     | 0D             | ENTER key
VK_SHIFT      | 10             | SHIFT key
VK_CONTROL    | 11             | CTRL key
VK_MENU       | 12             | ALT key
VK_PAUSE      | 13             | PAUSE key
VK_CAPITAL    | 14             | CAPS LOCK key
VK_ESCAPE     | 1B             | ESC key
VK_SPACE      | 20             | SPACEBAR
VK_PRIOR      | 21             | PAGE UP key
VK_NEXT       | 22             | PAGE DOWN key
VK_END        | 23             | END key
VK_HOME       | 24             | HOME key
VK_LEFT       | 25             | LEFT ARROW key
VK_UP         | 26             | UP ARROW key
VK_RIGHT      | 27             | RIGHT ARROW key
VK_DOWN       | 28             | DOWN ARROW key
VK_SELECT     | 29             | SELECT key
VK_PRINT      | 2A             | PRINT key
VK_EXECUTE    | 2B             | EXECUTE key
VK_SNAPSHOT   | 2C             | PRINT SCREEN key
VK_INSERT     | 2D             | INS key
VK_DELETE     | 2E             | DEL key
VK_HELP       | 2F             | HELP key
              | 30             | 0 key
              | 31             | 1 key
              | 32             | 2 key
              | 33             | 3 key
              | 34             | 4 key
              | 35             | 5 key
              | 36             | 6 key
              | 37             | 7 key
              | 38             | 8 key
              | 39             | 9 key
              | 41             | A key
              | 42             | B key
              | 43             | C key
              | 44             | D key
              | 45             | E key
              | 46             | F key
              | 47             | G key
              | 48             | H key
              | 49             | I key
              | 4A             | J key
              | 4B             | K key
              | 4C             | L key
              | 4D             | M key
              | 4E             | N key
              | 4F             | O key
              | 50             | P key
              | 51             | Q key
              | 52             | R key
              | 53             | S key
              | 54             | T key
              | 55             | U key
              | 56             | V key
              | 57             | W key
              | 58             | X key
              | 59             | Y key
              | 5A             | Z key
VK_NUMPAD0    | 60             | Numeric keypad 0 key
VK_NUMPAD1    | 61             | Numeric keypad 1 key
VK_NUMPAD2    | 62             | Numeric keypad 2 key
VK_NUMPAD3    | 63             | Numeric keypad 3 key
VK_NUMPAD4    | 64             | Numeric keypad 4 key
VK_NUMPAD5    | 65             | Numeric keypad 5 key
VK_NUMPAD6    | 66             | Numeric keypad 6 key
VK_NUMPAD7    | 67             | Numeric keypad 7 key
VK_NUMPAD8    | 68             | Numeric keypad 8 key
VK_NUMPAD9    | 69             | Numeric keypad 9 key
VK_SEPARATOR  | 6C             | Separator key
VK_SUBTRACT   | 6D             | Subtract key
VK_DECIMAL    | 6E             | Decimal key
VK_DIVIDE     | 6F             | Divide key
VK_F1         | 70             | F1 key
VK_F2         | 71             | F2 key
VK_F3         | 72             | F3 key
VK_F4         | 73             | F4 key
VK_F5         | 74             | F5 key
VK_F6         | 75             | F6 key
VK_F7         | 76             | F7 key
VK_F8         | 77             | F8 key
VK_F9         | 78             | F9 key
VK_F10        | 79             | F10 key
VK_F11        | 7A             | F11 key
VK_F12        | 7B             | F12 key
VK_F13        | 7C             | F13 key
VK_F14        | 7D             | F14 key
VK_F15        | 7E             | F15 key
VK_F16        | 7F             | F16 key
VK_F17        | 80H            | F17 key
VK_F18        | 81H            | F18 key
VK_F19        | 82H            | F19 key
VK_F20        | 83H            | F20 key
VK_F21        | 84H            | F21 key
VK_F22        | 85H            | F22 key
VK_F23        | 86H            | F23 key
VK_F24        | 87H            | F24 key
VK_NUMLOCK    | 90             | NUM LOCK key
VK_SCROLL     | 91             | SCROLL LOCK key
VK_LSHIFT     | A0             | Left SHIFT key
VK_RSHIFT     | A1             | Right SHIFT key
VK_LCONTROL   | A2             | Left CONTROL key
VK_RCONTROL   | A3             | Right CONTROL key
VK_LMENU      | A4             | Left MENU key
VK_RMENU      | A5             | Right MENU key
VK_PLAY       | FA             | Play key
VK_ZOOM       | FB             | Zoom key
