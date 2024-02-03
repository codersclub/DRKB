---
Title: Решение проблемы передачи фокуса TDBGrid
Date: 01.01.2007
---


Решение проблемы передачи фокуса TDBGrid
========================================

::: {.date}
01.01.2007
:::

В данном документе содержится решение проблемы невозможности получения
DBGrid-ом фокуса после щелчка на каком-либо элементе управления
родительской формы, в то время, как DBGrid находится на ее дочерней
MDI-форме.

Относится ко всем версиям Delphi

Очевидно, DBGrid имеет некоторые проблемы с управлением фокусом, если он
находится на дочерней MDI-форме. Эта проблема решена в приведенном ниже
наследнике TDBGrid, в котором обрабатываются мышиные сообщения и
выясняется когда фокус должен быть передан сетке. Наследник создан в
виде компонента, который легко устанавливается в Палитру Компонентов.
Примечание: код адаптирован для всех версий Delphi. Проблемы могут быть
в Delphi 2 и 3, если вы забудете заменить устаревшие в этих версиях
модули "winprocs" и "wintypes" на "windows."

    unit FixedDBGrid;
     
    interface
     
    uses
     
      Winprocs, wintypes, Messages, SysUtils, Classes, Graphics,
      Controls, Forms, Dialogs, Grids, DBGrids;
     
    type
     
      TFixedDBGrid = class(TDBGrid)
      private
        { Private declarations }
      protected
        { Protected declarations }
      public
        { Public declarations }
        procedure WMRButtonDown(var Message: TWMRButtonDown); message
          WM_RBUTTONDOWN;
        procedure WMLButtonDown(var Message: TWMLButtonDown); message
          WM_LBUTTONDOWN;
      published
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    procedure TFixedDBGrid.WMRButtonDown(var Message: TWMRButtonDown);
    begin
     
      winprocs.SetFocus(handle); {помните, что winprocs относится только к Delphi 1!}
      inherited;
    end;
     
    procedure TFixedDBGrid.WMLButtonDown(var Message: TWMLButtonDown);
    begin
     
      winprocs.SetFocus(handle); {помните, что winprocs относится только к Delphi 1!}
      inherited;
    end;
     
    procedure Register;
    begin
     
      RegisterComponents('Samples', [TFixedDBGrid]);
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
