---
Title: Прямой вызов Hint
Author: Nomadic
Date: 01.01.2007
---


Прямой вызов Hint
=================

::: {.date}
01.01.2007
:::

    function RevealHint(Control: TControl): THintWindow;
    {----------------------------------------------------------------}
    { Демонстрирует всплывающую подсказку для определенного элемента }
    { управления (Control), возвращает ссылку на hint-объект,        }
    { поэтому в дальнейшем подсказка может быть спрятана вызовом     }
    { RemoveHint (смотри ниже).                                      }
    {----------------------------------------------------------------}
     
    var
      ShortHint: string;
      AShortHint: array[0..255] of Char;
      HintPos: TPoint;
      HintBox: TRect;
    begin
      { Создаем окно: }
      Result := THintWindow.Create(Control);
     
      { Получаем первую часть подсказки до '|': }
      ShortHint := GetShortHint(Control.Hint);
     
      { Вычисляем месторасположение и размер окна подсказки }
      HintPos := Control.ClientOrigin;
      Inc(HintPos.Y, Control.Height + 6);
      < < < < Смотри примечание ниже
        HintBox := Bounds(0, 0, Screen.Width, 0);
      DrawText(Result.Canvas.Handle,
        StrPCopy(AShortHint, ShortHint), -1, HintBox,
        DT_CALCRECT or DT_LEFT or DT_WORDBREAK or DT_NOPREFIX);
      OffsetRect(HintBox, HintPos.X, HintPos.Y);
      Inc(HintBox.Right, 6);
      Inc(HintBox.Bottom, 2);
     
      { Теперь показываем окно: }
      Result.ActivateHint(HintBox, ShortHint);
    end; {RevealHint}
     
    procedure RemoveHint(var Hint: THintWindow);
    {----------------------------------------------------------------}
    { Освобождаем дескриптор окна всплывающей подсказки, выведенной  }
    { предыдущим RevealHint.                                         }
    {----------------------------------------------------------------}
     
    begin
      Hint.ReleaseHandle;
      Hint.Free;
      Hint := nil;
    end; {RemoveHint}

Строка с комментарием \<\<\<\< позиционирует подсказку ниже элемента
управления. Это может быть изменено, если по какой-то причине вам
необходима другая позиция окна с подсказкой.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Nomadic

    {Появление}
    IF h<>nil H.ReleaseHandle; {если чей-то хинт yже был, то его погасить}
    H:=THintWindow.Create(Окно-владелец хинта);
    H.ActivateHint(H.CalcHintRect(...),'hint hint nint');
    ....
    {UnПоявление :) - это возможно пpидется повесить на таймеp, котоpый бyдет
    обнyляться пpи каждом новом появлении хинта}
    IF h<>nil H.ReleaseHandle;

По-дpyгомy задача тоже pешаема, но очень плохо. (см исходник объекта
TApplication, он как pаз сабжами заведyет.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Сделаем это по нажатию на первую кнопку, а по нажатию на вторую кнопку
будем скрывать окно hint\'a:

    public
      { Public declarations }
      h: THintWindow;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if h<>nil then
        H.ReleaseHandle;
      H:=THintWindow.Create(Form1);
      H.ActivateHint(Form1.ClientRect, 'Это всплывающая подсказка');
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if h<>nil then
        H.ReleaseHandle;
    end; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
