---
Title: Модуль данных для каждого MDI Child
Date: 01.01.2007
---


Модуль данных для каждого MDI Child
===================================

::: {.date}
01.01.2007
:::

Когда во время разработки вы устанавливаете "DataSource"-свойство в
БД-компонентах для указания на модуль данных, VCL во время выполнения
приложения будет пытаться создать связь с существующим TDataModule,
основываясь на его свойтсве Name. Так, если вы добавите модуль данных к
вашему проекту и переместите его в свойстве проекта из колонки
автоматически создаваемых форм в колонку доступных, вы сможете
разработать форму, содержащую элементы управления для работы с базами
данных, после чего несколькими строчками кода можете создать экземпляр
формы, имеющий экземпляр собственного модуля данных.

С помощью Репозитория создайте "standard MDI application" (стандартное
MDI-приложение), в котором модуль TMDICHild будет похож на приведенный
ниже. Добавленные строки имеют комментарий {!}. Хитрости спрятаны в
конструкторе create и задании другого порядка следования операторов.

    unit Childwin;
     
    interface
     
    uses Windows, Classes, Graphics, Forms, Controls,
      ExtCtrls, DBCtrls, StdCtrls, Mask, Grids, DBGrids,
      DataM; {!} // Модуль TDataModule1
     
    type
      TMDIChild = class(TForm)
        DBGrid1: TDBGrid;
        DBGrid2: TDBGrid;
        DBEdit1: TDBEdit;
        DBEdit2: TDBEdit;
        DBNavigator1: TDBNavigator;
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
      private
        { Private declarations }
      public
        { Public declarations }
        {!} DM: TDataModule1;
        {!} constructor Create(AOwner: TComponent); override;
      end;
     
    implementation
     
    {$IFDEF XOXOXOX} // DataM должен находиться в секции interface. Необходимо для среды
     
    uses DataM; // времени проектирования. Определение "XOXOXOX" подразумевает,
    {$ENDIF} // что это никогда не будет определено, но чтобы компилятор видел это.
     
    {$R *.DFM}
     
    {!} constructor TMDIChild.Create;
    {!}
    begin
      {!} DM := TDataModule1.Create(Application);
      {!} inherited Create(AOwner);
      {!} DM.Name := '';
      {!}
    end;
     
    procedure TMDIChild.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      Action := caFree;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
