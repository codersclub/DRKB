---
Title: Кнопка со звуком
Date: 01.01.2007
---


Кнопка со звуком
================

::: {.date}
01.01.2007
:::

Когда Вы нажимаете на кнопку, то видите трёхмерный эффект нажатия. А как
же насчёт четвёртого измерения, например звука ? Ну тогда нам
понадобится звук для нажатия и звук для отпускания кнопки. Если есть
желание, то можно добавить даже речевую подсказку, однако не будем
сильно углубляться.

Компонент звуковой кнопки имеет два новых свойства:

    type
      TDdhSoundButton = class(TButton)
      private
        FSoundUp, FSoundDown: string;
      protected
        procedure MouseDown(Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer); override;
        procedure MouseUp(Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer); override;
      published
        property SoundUp: string
          read FSoundUp write FSoundUp;
        property SoundDown: string
          read FSoundDown write FSoundDown;
      end;

Звуки будут проигрываться при нажатии и отпускании кнопки:

    procedure TDdhSoundButton.MouseDown(
      Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      inherited;
      PlaySound (PChar (FSoundDown), 0, snd_Async);
    end;
     
    procedure TDdhSoundButton.MouseUp(Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      inherited;
      PlaySound (PChar (FSoundUp), 0, snd_Async);
    end;

Взято из <https://forum.sources.ru>
