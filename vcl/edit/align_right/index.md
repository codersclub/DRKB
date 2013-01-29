---
Title: Выравнивание по правому краю в TEdit
Author: МММ
Date: 01.01.2007
---


Выравнивание по правому краю в TEdit
====================================

::: {.date}
01.01.2007
:::

    type 

      TNumEdit = class(TEdit) 
        procedure CreateParams(var Params: TCreateParams); override; 
    ....... 
     
     
    procedure TNumEdit.CreateParams(var Params: TCreateParams); 
    begin 
      inherited CreateParams(Params); 
      Params.Style := Params.Style or ES_MULTILINE or ES_RIGHT; 
    end; 

Автор: МММ

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

    { Пример TEdit с правым выравниванием 
    © Song }
     
    type
     TForm1 = class(TForm)
       procedure FormCreate(Sender: TObject);
     private
       { Private declarations }
     public
       { Public declarations }
     end;
     
    { Обявляем класс нашего едита как потомок от стандартного}
    type TMySuperEdit=class(TCustomEdit)
    public
      { Внутри класса переопредялем процедуру CreateParams,
         т.к. нужный нам стиль можно изменить только на создании или пересоздании
         окна  }
     Procedure CreateParams(Var Params: TCreateParams); override;
    end;
     
    var
     Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    Procedure TMySuperEdit.CreateParams(Var Params: TCreateParams);
    Begin
     { Вызываем родительский обработчик, чтобы он сделал все процедуры по созданию объекта класса }
    inherited CreateParams(Params);
      { Изменяем стиль }
    With Params Do Style:=Style or ES_RIGHT;
    End;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     { Создаём едит на основе нашего класса и кладём его на форму } 
    With TMySuperEdit.Create(Self) Do Parent:=Self;
    end;

Автор: Song

Взято из <https://forum.sources.ru>

Идея заключается в том, как сделать правое выравнивание текста в TEdit,
не прибегая к написанию нового компонента.

Для этого можно воспользоваться канвасом. Так как TEdit не имеет
канваса, то сперва мы создадим TControlCanvas а затем, прикрепим TEdit к
этому канвасу.

Теперь нам доступны все свойства и методы TControlCanvas, поэтому мы
спокойно можем настраивать в нём текст. Ниже приведёна процедура,
реализующая всё вышесказанное.

    procedure RJustifyEdit(var ThisEdit : TEdit); 
    var 
     Left, Width : Integer; 
     GString : String; 
     Rgn : TRect; 
     TheCanvas : TControlCanvas; 
    begin 
      TheCanvas := TControlCanvas.Create; 
      try 
        TheCanvas.Control := ThisEdit; 
        GString := ThisEdit.Text; 
        Rgn     := ThisEdit.ClientRect; 
        TheCanvas.FillRect(Rgn); 
        Width   := TheCanvas.TextWidth(GString); 
        Left := Rgn.Right - Width - 1; 
        TheCanvas.TextRect(Rgn, Left, 0, GString); 
      finally 
        TheCanvas.Free; 
      end ; 
    end;

Взято из <https://forum.sources.ru>
