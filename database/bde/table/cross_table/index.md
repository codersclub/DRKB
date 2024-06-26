---
Title: Создание кросс-таблицы
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Создание кросс-таблицы
======================

Вы можете создать их в DBD как QBE-шки. Пользуясь компонентом TQBE для
загрузки одной из библиотек, вы можете непосредственно использовать
QBE-шки в вашем Delphi-приложении.

В следующем примере предполагается, что каждый служащий каждый день
сообщает оператору о своем месторасположении. Код определяет начало
трудовой недели с понедельника плюс еще четыре рабочих дня с показом
соответствующей даты. Строки с 1 по 5 в QBE1.QBE (нулевая описательная)
в нижеприведенной процедуре заменяются кодом. Результат всего этого в
том, что строка (если имеется) для каждого человека отображается в
колонке установленного результата и значение \'X\' включается если
только запись существует. Для создания агрегатной таблицы можно было бы
подсчитывать результаты.

Текст в QBE1.QBE :

    CALLIN.DB | StaffNo   | Date    |
              | _join1    | 3/10/95 |
              | _join2    | 3/11/95 |
              | _join3    | 3/12/95 |
              | _join4    | 3/13/95 |
              | _join5    | 3/14/95 |


    XTAB.DB   | StaffNo   |Mon       |Tue       |Wed       |Thu       |Fri       |
              | _join1    |changeto X|          |          |          |          |
              | _join2    |          |changeto X|          |          |          |
              | _join3    |          |          |changeto X|          |          |
              | _join4    |          |          |          |changeto X|          |
              | _join5    |          |          |          |          |changeto X|


    procedure TCallInReport.ButtonSelectClick(Sender: TObject);
    begin
      TableXTab.active := false;
      if EditWeekOf.Text = '' then
      begin
        messageBeep(0);
        messageDlg('Для выбора записи необходима дата.', mtInformation, [mbOK], 0);
        exit;
      end;
     
      Screen.Cursor := crHourGlass;
     
      dtWeekOf := StrToDate(EditWeekOf.Text);
      dtStartDate := dtWeekOf - DayOfWeek(dtWeekOf) + 2;
     
      TableXTab.active := false;
      TableXTab.EmptyTable;
      TableXTab.active := true;
     
      {
      Замените строки 1 - 5 в QBE1.QBE реальными датами
      }
      QBE1.QBE.Strings[1] := '  | _join1  | ' + DateToStr(dtStartDate) + ' | ';
      QBE1.QBE.Strings[2] := '  | _join2  | ' + DateToStr(dtStartDate + 1) + ' | ';
      QBE1.QBE.Strings[3] := '  | _join3  | ' + DateToStr(dtStartDate + 2) + ' | ';
      QBE1.QBE.Strings[4] := '  | _join4  | ' + DateToStr(dtStartDate + 3) + ' | ';
      QBE1.QBE.Strings[5] := '  | _join5  | ' + DateToStr(dtStartDate + 4) + ' | ';
     
      try
        QBE1.active := true;
      except
        on E: EDataBaseError do
        begin
          if E.Message = 'Ошибка создания дескриптора курсора' then
            { Ничего не делайте. Делая TQBE активной, мы пытаемся создать курсор.
              Это вызывает исключительную ситуацию, которую мы должны перехватить.
              Пока я не нашел способа как отделаться от исключения. }
          else
          begin
            Screen.Cursor := crDefault;
            raise;
          end;
        end;
      else
        Screen.Cursor := crDefault;
        raise;
      end;
      TableXTab.refresh;
      Screen.Cursor := crDefault;
      TableXTab.active := true;
    end;

