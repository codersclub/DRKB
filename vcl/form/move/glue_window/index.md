---
Title: Липкие окошки
Author: Nashev
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Липкие окошки
=============

_Из одноимённой статьи с сайта delphi.about.com_

В статье рассматривается приём создания обработчиков сообщений, которые
позволяют форме при перетаскивании "прилипать" к краям экранной
области.

Конечно же в Win API такой возможности не предусмотрено, поэтому мы
воспользуемся сообщениями Windows. Как нам извесно, Delphi обрабатывает
сообщения через события, генерируя его в тот момент, когда Windows
посылает сообщений приложению. Однако некоторые сообщения не доходят до
нас. Например, при изменении размеров формы, генерируется событие
OnResize, соотвествующее сообщению WM\_SIZE, но при перетаскивании формы
никакой реакции не происходит. Конечно же форма может получить это
сообщение, но изначально никаких действий для данного сообщения не
предусмотрено.

Итак, при перемещении, окну посылается сообщение WM\_MOVING. Обрабатывая
данной сообщение, приложение может отслеживать размер и расположение
перетаскиваемого квадрата и, при необходимости, изменять их.

Так же существует сообщение WM\_WINDOWPOSCHANGING, которое посылается
окну, в случае, если его размер, расположение или место в Z порядке
собираются измениться, как результат вызова функции SetWindowPos либо
другой функции управления окном.

Чаще всего с сообщением передаются дополнительные параметры, которые
сообщают нам необходимую информацию. Например, сообщение WM\_MOVE,
указывающее на то, что форма изменила своё местоположение, так же
передаёт в параметре LPARAM новые координаты X и Y.

Сообщение WM\_WINDOWPOSCHANGING передаёт нам ТОЛЬКО один параметр -
указатель на структуру WindowPos, которая содержит информацию о новом
размере и местоположении окна. Вот как выглядит структура WindowPos:

    TWindowPos = packed record
      hwnd: HWND; {Identifies the window.}
      hwndInsertAfter: HWND; {Window above this one}
      x: Integer; {Left edge of the window}
      y: Integer; {Right edge of the window}
      cx: Integer; {Window width}
      cy: Integer; {Window height}
      flags: UINT; {Window-positioning options.}
    end;

Наша задача проста: нам необходима, чтобы форма прилипла к краю экрана,
если она находится на определённом расстоянии от окна (допустим 20
пикселей).

**Пример**

К новой форме добавьте Label, один контрол Edit и четыре Check boxes.
Измените имя контрола Edit на edStickAt. Измените имена чекбоксов на
chkLeft, chkTop, и т.д... Для установки количества пикселей используем
edStickAt, который будет использоваться для определения необходимого
расстояния до края экрана достаточного для приклеивания формы.

Нас интересует только одно сообщение WM\_WINDOWPOSCHANGING. Обработчик
для данного сообщения будет объявлен в секции private. Ниже приведён
полный код этого процедуры "прилипания" вместе с комментариями.
Обратите внимание, что Вы можете предотвратить "прилипание" формы к
определённому краю, путё снятия нужной галочки.

Для получения рабочей области декстопа (минус панель задач, панель
Microsoft и т.д.), используем SystemParametersInfo, первый параметр
которой SPI\_GETWORKAREA.

    ...
     
    private
      procedure WMWINDOWPOSCHANGING
                (Var Msg: TWMWINDOWPOSCHANGING);
                 message WM_WINDOWPOSCHANGING;
     
    ...
     
    procedure TfrMain.WMWINDOWPOSCHANGING
              (var Msg: TWMWINDOWPOSCHANGING);
    const
      Docked: Boolean = FALSE;
    var
      rWorkArea: TRect;
      StickAt : Word;
    begin
      StickAt := StrToInt(edStickAt.Text);
     
      SystemParametersInfo
         (SPI_GETWORKAREA, 0, @rWorkArea, 0);
     
      with Msg.WindowPos^ do begin
        if chkLeft.Checked then
         if x <= rWorkArea.Left + StickAt then begin
          x := rWorkArea.Left;
          Docked := TRUE;
         end;
     
        if chkRight.Checked then
         if x + cx >= rWorkArea.Right - StickAt then begin
          x := rWorkArea.Right - cx;
          Docked := TRUE;
         end;
     
        if chkTop.Checked then
         if y <= rWorkArea.Top + StickAt then begin
          y := rWorkArea.Top;
          Docked := TRUE;
         end;
     
        if chkBottom.Checked then
         if y + cy >= rWorkArea.Bottom - StickAt then begin
          y := rWorkArea.Bottom - cy;
          Docked := TRUE;
         end;
     
        if Docked then begin
          with rWorkArea do begin
          // не должна вылезать за пределы экрана
          if x < Left then x := Left;
          if x + cx > Right then x := Right - cx;
          if y < Top then y := Top;
          if y + cy > Bottom then y := Bottom - cy;
          end; {ширина rWorkArea}
        end; {}
      end; {с Msg.WindowPos^}
     
      inherited;
    end;
    end.

Теперь достаточно запустить проект и перетащить форму к любому краю
экрана.

**Комментарии:**

Author: Nashev

а так короче...  
И, ИМХО, лучше:

    procedure TCustomGlueForm.WMWindowPosChanging1(var Msg: TWMWindowPosChanging);
    var
      WorkArea: TRect;
      StickAt : Word;
    begin
      StickAt := 10;
      SystemParametersInfo(SPI_GETWORKAREA, 0, @WorkArea, 0);
      with WorkArea, Msg.WindowPos^ do 
      begin
        // Сдвигаем границы для сравнения с левой и верхней сторонами
        Right:=Right-cx;
        Bottom:=Bottom-cy;
        if abs(Left - x) <= StickAt then x := Left;
        if abs(Right - x) <= StickAt then x := Right;
        if abs(Top - y) <= StickAt then y := Top;
        if abs(Bottom - y) <= StickAt then y := Bottom;
      end;
      inherited;
    end;

В проекте осталось 2 глюка:

1) Если у формы, к которой прицепили другую форму за правую/нижнюю
границы попробовать переместить эти границы, прицепленная форма
останется на месте но все равно будет прикрепленной.

2) Иногда 3 формы прикрепляются друг к другу, и иначе, как
воспользовавшись 1-ым глюком, их не расцепить.

**Состав проекта:**

сам проект, uCustomGlueForm - форма с добавленной липкостью 3 формы -
пустышки, наследники TCustomGlueForm

Для использования сделанного в своих проектах надо добавить в проект, и
свои формы создавать, наследуя от него, например, через мастер
"File/New..."

В принципе, если липкость нужна без прилипания (а это уже работает без
глюков) можно выкинуть все методы, кроме

    procedure WMWindowPosChanging(var Msg: TWMWindowPosChanging);
              message WM_WINDOWPOSCHANGING;

и все переменные, а в самом WMWindowPosChanging удалить все упоминания
этих переменных.

