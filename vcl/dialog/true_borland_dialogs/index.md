---
Title: Правильные диалоги от Борланда
Date: 01.01.2007
Author: Сергей Горбань
Source: <https://www.delphikingdom.com>
---


Правильные диалоги от Борланда
==============================

Если покопаться в фирменных "Дельфовых" примерах, можно найти ГОРАЗДО
более удачную конструкцию (которую, кстати, я уже давно использую).

Еще раз подчеркну - это не моя придумка, а ребят из Борланда.

Эта конструкция позволяет:

- Возвращать ЛЮБЫЕ значения;
- ДИНАМИЧЕСКИ создавать форму;
- Еще куча всяких "бонусов", просто лень описывать :-)

Итак, смотрим исходники...

В этом примере я привел два наиболее типичных случая.

1-й - InputString - просто ввод, без анализа отмены,  
второй - MrInputString - с анализом отмены ввода (ModalResult).

Оба случая используют начальные значения. Без них - Еще проще...

В принципе - ваша фантазия ничем не ограничивается. Я, например, храню
последние вводившиеся значения в реестре и читаю их оттуда после
создания формы. Удобно.

Пользователь не мается, вводя по 10 раз одно и то же, а у меня не болит
голова с инициализацией полей (есть специальный класс, который этим
занимается, но это отдельная тема...)

ИСХОДНИКИ:

    //**************************************************************
    //Основной модуль Обратите Внимание!  "uses Dialog;"
     
    implementation
     
    {$R *.dfm}
    uses
      Dialog;
     
    procedure TForm1.BitBtn1Click(Sender: TObject);
    begin
      ShowMessage('Вы ввели '+InputString('Начальное значение'));
    end;
     
    procedure TForm1.BitBtn2Click(Sender: TObject);
    Var
      Str: String;
    begin
      Str:='Начальное значение';
      If MrInputString(Str) = mrOk Then
        ShowMessage('Вы ввели '+Str)
      Else
        ShowMessage('Вы отменили ввод');
    end;
     
    //********************************************************
    //Модуль диалога
    unit Dialog;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ExtCtrls, Buttons;
     
    type
      TOptionsDlg = class(TForm)
        Bevel1: TBevel;
        BitBtn1: TBitBtn;
        BitBtn2: TBitBtn;
        Edit1: TEdit;
        Label1: TLabel;
        Bevel2: TBevel;
        Label3: TLabel;
        procedure FormKeyDown(Sender: TObject; var Key: Word;
          Shift: TShiftState);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      OptionsDlg: TOptionsDlg;
     
    function InputString(BeginVal: String): String;
    function MrInputString(Var Str: String): TModalResult;
     
    implementation
     
    {$R *.dfm}
     
    function InputString(BeginVal: String): String;
    begin
      With TOptionsDlg.Create(Application.MainForm) do
        Try
          Edit1.Text:=BeginVal;
          If ShowModal = mrOk Then
            Result:=Edit1.Text
          Else
            Result:='"Отмена"';
        Finally
          Free;
        End;
    end;
     
    function MrInputString(Var Str: String): TModalResult;
    begin
      With TOptionsDlg.Create(Application.MainForm) do
        Try
          Edit1.Text:=Str;
          Result:=ShowModal;
          Str:=Edit1.Text;
        Finally
          Free;
        End;
    end;
     
    procedure TOptionsDlg.FormKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    begin
      Case Key of
        27:     ModalResult:=mrCancel;
        13: ModalResult:=mrOk;
      End;
    end;
     
    end.

