---
Title: Проверка на соответствие содержимого TEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Проверка на соответствие содержимого TEdit
==========================================

Предположим, вы регулярно пользуетесь компонентами TEdit (в отличие от
компонентов TDBEdit), и если так, то наилучшим местом для осуществления
проверки на соответствие является обработчик события OnExit компонента
TEdit. Данное событие наступает при каждом покидании фокуса компонента.

Обычно, при вводе неправильного текста в поле редактирования, у вас
возникает желание послать предупреждение пользователю и вернуть фокус
обратно. Тем не менее, в данном решении трудность подстерегает при
попытке установить фокус в обработчике события OnExit. Поскольку Windows
остается "посередине" при передаче фокуса от одного элемента
управления другому в обработчике события OnExit, вы можете получить
состояние нестабильного поведения компонентов, если попытаетесь в это
время изменить фокус.

Решением в данной ситуации может служить попытка послать сообщение в
обработчике события компонента TEdit OnExit вашей форме. Определенное
пользователем и посланное сообщение может послужить отправной точкой для
начала проверки содержимого поля редактирования. Поскольку посланное
сообщение располагается в конце очереди сообщений, то это дает Windows
возможность завершить изменение фокуса прежде, чем вы попытаетесь
передать фокус другому элементу управления.

Помещенный ниже текст модуля и текстовое представление формы (DFM)
призваны продемонстрировать эту технику:

    unit Unit1;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls, Forms,
        Dialogs, StdCtrls, Mask;
     
    const
      { Определенное пользователем сообщение }
      um_ValidateInput = wm_User + 100;
     
    type
      TForm1 = class(TForm)
        Edit1: TEdit;
        Edit2: TEdit;
        Edit3: TEdit;
        Edit4: TEdit;
        Button1: TButton;
        MaskEdit1: TMaskEdit;
        procedure Edit1Exit(Sender: TObject);
      private
        { обработчик определенного пользователем события }
        procedure ValidateInput(var M: TMessage); message um_ValidateInput;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.ValidateInput(var M: TMessage);
    begin
      { Следующая строка является строкой проверки. Я хочу убедиться в том, }
      { что первый символ является буквенным символом верхнего регистра. }
      { Помните о преобразовании типа lParam к TEdit. }
      if not (TEdit(M.lParam).Text[1] in ['a'..'z']) then
      begin
        ShowMessage('Содержимое не отвечает требованиям'); { Орем на пользователя }
        TEdit(M.lParam).SetFocus; { Снова устанавливаем фокус }
      end;
    end;
     
    procedure TForm1.Edit1Exit(Sender: TObject);
    begin
      { Посылаем сообщение самому себе, говорящее о необходимости }
      { проверки содержимого. Передаем экземпляр TEdit (Self) как }
      { lParam сообщения. }
      PostMessage(Handle, um_ValidateInput, 0, longint(Sender));
    end;
     
    end.

    object Form1: TForm1
      Left = 200
        Top = 99
        Width = 318
        Height = 205
        Caption = 'Form1'
        Font.Color = clWindowText
        Font.Height = -13
        Font.Name = 'System'
        Font.Style = []
        PixelsPerInch = 96
        TextHeight = 16
        object Edit1: TEdit
        Left = 32
          Top = 32
          Width = 121
          Height = 24
          TabOrder = 0
          Text = 'Edit1'
          OnExit = Edit1Exit
      end
      object Edit2: TEdit
        Left = 160
          Top = 32
          Width = 121
          Height = 24
          TabOrder = 1
          Text = 'Edit2'
          OnExit = Edit1Exit
      end
      object Edit3: TEdit
        Left = 32
          Top = 64
          Width = 121
          Height = 24
          TabOrder = 2
          Text = 'Edit3'
          OnExit = Edit1Exit
      end
      object Edit4: TEdit
        Left = 160
          Top = 64
          Width = 121
          Height = 24
          TabOrder = 3
          Text = 'Edit4'
          OnExit = Edit1Exit
      end
      object Button1: TButton
        Left = 112
          Top = 136
          Width = 89
          Height = 33
          Caption = 'Button1'
          TabOrder = 4
      end
    end

