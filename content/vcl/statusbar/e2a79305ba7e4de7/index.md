---
Title: Показ всплывающих подсказок в строке состояния
Author: Иваненко Фёдор Григорьевич
Date: 01.01.2007
---


Показ всплывающих подсказок в строке состояния
==============================================

::: {.date}
01.01.2007
:::

Я покажу как сделать так, чтобы строка состояния (Status Bar) показывала
все всплывающие подсказки (Hint) элементов управления формы при
нахождении курсора мыши в области компонента. Имеется пара решений
данной задачи, но в любом случае вы должны создать код для каждой формы
(пока я не знаю другого решения).

Шаг 1:

Расположите TStatusBar на всех формах, где вы хотите увидеть подсказки в
строке состояния. Установите свойство SimplePanel в True и присвойте
компоненту другое имя (я использую SBStatus). Смотри мой комментарий
относительно имени, который я поместил в шаге 4.

Шаг 2:

Создайте необходимые подсказки в свойствах Hint. Не забудьте вставить
\'\|\', если вам необходим длинный текст.

Шаг 3:

Поместите следующую строку в обработчике события FormCreate вашей формы:

Application.OnHint := DisplayHint;

Шаг 4:

Создайте эту процедуру. Пожалуйста обратите внимание на комментарии.

    procedure TFrmMain.DisplayHint(Sender: TObject);
    var
      Counter, NumComps: integer;
    begin
      with Screen.ActiveForm do
      begin
        NumComps := ControlCount - 1;
        for Counter := 0 to NumComps do
          {SBStatus - имя всех моих компонентов TStatusBar.
          При необходимости его можно изменить.}
          if (TControl(Controls[Counter]).Name = 'SBStatus') then
          begin
            if (Application.Hint = '') then
              {ConWorkingName - используемая константа.
              При необходимости ее можно изменить.}
              TStatusBar(Controls[Counter]).SimpleText := ConWorkingName
            else
              TStatusBar(Controls[Counter]).SimpleText := Application.Hint;
            break;
          end;
      end;
    end; {DisplayHint}

Не забудьте поместить \'Procedure DisplayHint(Sender: TObject) в секции
Public.

Это все, что вы должны сделать. Если вы хотите придать такую
функциональность другим формам, просто поместите на них TStatusBar и
установите свойство Hint у необходимых компонентов. Я надеюсь это
просто.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

Автор: Иваненко Фёдор Григорьевич

Пришло мне письмо:

\...cовет за номером 000306 содержит интересную идею \-- выводить
Hint\'ы не на основную форму, а на активную, я сам до этого не дошел\...
Но не совсем понятно, чем автору не понравился стандартный метод
TForm.FindComponent, существующий со времен Delphi I ? С его
использованием метод ShowHint выглядит попроще, да и работает не хуже:

    procedure TAnyForm.ShowHint;
    var
      C: TStatusBar;
    begin
      // ищем наш StatusBar1 на активной форме
      C := TStatusBar(Screen.ActiveForm.FindComponent('StatusBar1'));
      // если не найден -- ищем на основной форме
      if not Assigned(C) then
        C := TStatusBar(Application.MainForm.FindComponent('StatusBar1'));
      // если что-то обнаружено -- рисуем на н?м наш текст
      if Assigned(C) then
        C.SimpleText := '  ' + Application.Hint;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
