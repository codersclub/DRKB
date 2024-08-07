---
Title: Использование обработчика OnHint при наличии нескольких форм
Date: 01.01.2007
Source: <https://dmitry9.nm.ru/info/>
---


Использование обработчика OnHint при наличии нескольких форм
============================================================

В Online Help и в Visual Component Library Reference описан пример
обработчика
события OnHint объекта TApplication. Пример показывает, как можно
использовать
панель для отображения подсказок (hint), связанных с другими
компонентами.

В примере обработчик OnHint устанавливается во время обработки события
OnCreate для формы. В программе, включающей более чем одну форму, будет трудно
использовать эту технику.

Перемещение присваивания обработчика OnHint из события OnCreate формы в
событие OnActivate позволит различным формам данного приложения работать
с подсказками, как им нужно.

Ниже приведен измененный пример из OnLine Help и VCL Reference.

    type
      TForm1 = class(TForm)
        Button1: TButton;
        Panel1: TPanel;
        Edit1: TEdit;
        procedure FormActivate(Sender: TObject);
      private
        { Private declarations }
      public
        procedure DisplayHint(Sender: TObject);
      end;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.DisplayHint(Sender: TObject);
    begin
      Panel1.Caption := Application.Hint;
    end;
     
    procedure TForm1.FormActivate(Sender: TObject);
    begin
      Application.OnHint := DisplayHint;
    end;

