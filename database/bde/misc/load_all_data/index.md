---
Title: Загрузить все записи в TStringList одним махом?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Загрузить все записи в TStringList одним махом?
===============================================

    { Loading millions of records into a stringlist can be very slow }
     
    procedure TForm1.SlowLoadingIntoStringList(StringList: TStringList);
    begin
      StringList.Clear;
      with SourceTable do
      begin
        Open;
        DisableControls;
        try
          while not EOF do
          begin
            StringList.Add(FieldByName('OriginalData').AsString);
            Next;
          end;
        finally
          EnableControls;
          Close;
        end;
      end;
    end;
     
    { This is much, much faster }
    procedure TForm1.QuickLoadingIntoStringList(StringList: TStringList);
    begin
      with CacheTable do
      begin
        Open;
        try
          StringList.Text := FieldByName('Data').AsString;
        finally
          Close;
        end;
      end;
    end;
     
How can this be done?
     
In Microsoft SQL Server 7, you can write a stored procedure that updates every night
a cache table that holds all the data you want in a single column and row.
In this example, you get the data from a SourceTable and put it all in a Cachetable.
The CacheTable has one blob column and must have only one row.
Here it is the SQL code:

    Create Table CacheTable
    (Data Text NULL)
    GO

    Create

    procedure PopulateCacheTable as
      begin
      set NOCOUNT on
      DECLARE @ptrval binary(16), @Value varchar(600) -- a good Value for the expected maximum Length
      -- You must set 'select into/bulkcopy' option to True in order to run this sp
      DECLARE @dbname nvarchar(128)
      set @dbname = db_name()
    EXEC sp_dboption @dbname, 'select into/bulkcopy', 'true'
    -- Declare a cursor
    DECLARE scr CURSOR for
    SELECT  OriginalData + char(13) + char(10) -- each line in a TStringList is
    separated by a #13#10
    FROM    SourceTable
    -- The CacheTable Table must have only one record
    if EXISTS (SELECT * FROM CacheTable)
    Update CacheTable set Data = ''
    else
    Insert CacheTable VALUES('')
    -- Get a Pointer to the field we want to Update
    SELECT @ptrval = TEXTPTR(Data) FROM CacheTable

    Open scr
    FETCH Next FROM scr INTO @Value
    while @ @FETCH_STATUS = 0
    begin -- This UPDATETEXT appends each Value to the 
    end 
    of the blob field
    UPDATETEXT CacheTable.Data @ptrval NULL 0 @Value
    FETCH Next FROM scr INTO @Value
    end
    Close scr
    DEALLOCATE scr
    -- Reset this option to False
    EXEC sp_dboption @dbname, 'select into/bulkcopy', 'false'
    end
    GO


You may need to increase the BLOB SIZE parameter if you use BDE.

