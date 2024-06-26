---
Title: Как очистить базу данных, оставив только структуру?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как очистить базу данных, оставив только структуру?
===================================================

**ЗАМЕЧАНИЕ:**
Этот пример не работает в режиме редактирования, так как
таблица должна быть открыта в эксклюзивном режиме.

    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      {Opens the table in exclusive mode} 
      Try 
        With Table1 Do 
        Begin 
          Active:=False; 
          Exclusive:=True; 
          Active:=True; 
          try 
            EmptyTable; 
          except 
            ShowMessage('Cannot empty database'); 
          end; 
        End 
      Except 
        ShowMessage('cannot open table in exclusive mode'); 
      End 
    end;


---
**Примечание Vit:**

Если требуется очистить таблицу не прибегая к эксклюзивному доступу или
используя другие способы доступа помимо BDE то рекомендуется выполнить
квери:

    Delete From MyTable

Которая полностью очистит таблицу.

Для MS SQL Server существует и другой способ - выполнение квери:

    Truncate Table MyTable

Различие между Delete и Truncate заключается в том, что для операции
Delete создаётся запись в Transaction log, что обеспечивает более
высокую надёжность, но при больших таблицах выполнение Delete может быть
весьма долгим. Напротив, Truncate в  Transaction log не попадает и
таблица любых размеров необратимо очищается практически мгновенно вне
зависимости от её размера. Delete - стандартная операция SQL и
поддерживается всеми базами данных, напротив, Truncate - операция  не
стандартная, поэтому поддерживается лишь отдельными базами данных.
