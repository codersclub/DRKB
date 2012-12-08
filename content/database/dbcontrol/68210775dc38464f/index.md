---
Title: ActiveControl имеет DataSet
Author: OAmiry (Borland)
Date: 01.01.2007
---


ActiveControl имеет DataSet
===========================

::: {.date}
01.01.2007
:::

Автор: OAmiry (Borland)

Для успешного кодирования необходимо включить typinfo в список
используемых модулей. Код данного примера инвертирует логическое
свойство Active набора данных, связанного с активным элементом
управления при каждом нажатии пользователем клавиши ESC.

    procedure TForm1.FormKeyUp(Sender: TObject; var Key: Word;
      Shift: TShiftState);
    var
      PropInfo: PPropInfo;
      PropValue: TObject;
      ds: TDataSource;
    begin
      if Key = VK_ESCAPE then
        { Основной код ниже }
      try
        ds := nil;
        { Проверяем, имеет ли компонент свойство DataSource }
        PropInfo := GetPropInfo(ActiveControl.ClassInfo, 'DataSource');
        if PropInfo <> nil then
          { Свойство компонента datasource типа class (например, TDataSource) }
          if PropInfo^.PropType^.Kind = tkClass then
          begin
            PropValue := TObject(GetOrdProp(ActiveControl, PropInfo));
            { Создаем слепок найденного TDataSource }
            ds := (PropValue as DB.TDataSource);
            { Используем dataset, связанный с datasource }
            if not (ds.DataSet.State in dsEditModes) then
              ds.DataSet.Active := not ds.DataSet.Active;
          end;
      except
        on E: EInvalidCast do
          ShowMessage('Ошибка. Ожидался DataSource');
      end;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
