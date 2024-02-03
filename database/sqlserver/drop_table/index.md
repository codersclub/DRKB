---
Title: Как удалить таблицу?
Date: 01.01.2007
---


Как удалить таблицу?
====================

::: {.date}
01.01.2007
:::

I\'ve been doing extensive work with Client/Server Delphi and MS SQL
Server as my back-end database. The operational model that I use for my
Client/Server is that the client application acts only as local
interface, and that all queries and calculations - even temporary files
- are performed or created on the server. Now this presents a couple of
problems in that garbage cleanup isn\'t quite as easy as it is when
using local tables as temporary files.

For instance, a lot of my programs create temporary files that I either
reference later in the program or that I use as temporary storage for
outer joins. Once I\'m done with them, I need to delete them. With local
tables, it\'s a snap. Just get a list of the tables, and with a little
bit of code that uses some Windows API calls, delete them. Not so easy
with SQL Server tables. The reason why is that you have to go through
the BDE to accomplish the task - something that\'s not necessarily very
intuitive. Luckily, however, it doesn\'t involve low-level BDE API
calls.

Below is a procedure listing that drops tables from any SQL Server
database. After the listing I\'ll discuss particulars...

Parameter Descriptions

    //var Ses : TSession;         //A valid, open session
    //DBName : String;            //Name of the SQL Server DB
    //ArTables : array of String; //An array of table names
    //StatMsg : TStatusMsg);      //A status message callback
                                  //procedure
     

TStatusMsg is a procedural type used as a callback procedure

    type
      TStatusMsg = procedure(Msg: string);
     
    procedure DropMSSQLTempTables(var Ses: TSession;
      DBName: string;
      ArTables: array of string;
      StatMsg: TStatusMsg);
    var
      N: Integer;
      qry: TQuery;
      lst: TStringList;
    begin
      lst := TStringList.Create;
     
      Ses.GetTableNames(DBName, '', False, False, lst);
     
      try
        for N := Low(arTables) to High(arTables) do
          if (lst.IndexOf(ArTables[N]) > 0) then
          begin
            StatMsg('Removing ' + arTables[N] +
              ' from client database');
            qry := TQuery.Create(nil);
            with qry do
            begin
              Active := False;
              SessionName := Ses.SessionName;
              DatabaseName := DBName;
              SQL.Add('DROP TABLE ' + arTables[N]);
              try
                ExecSQL;
              finally
                Free;
                qry := nil;
              end;
            end;
          end;
      finally
        lst.Free;
      end; { try/finally }
    end;

The pseudo-code for this is pretty easy.

1.        Get a listing of all tables in the SQL Server
database passed to the procedure.

2.        Get a table name from the table name array.

3.        If a passed table name happens to be in the list of
table retrieved from the database, DROP it.

4.        Repeat 2. and 3. until all table names have been
exhausted.

The reason why I do the comparison in step 3 is because if you issue a
DROP query against a non-existent table, SQL Server will issue an
exception. This methodology avoids that issue entirely.

Below is a detailed description of the parameters.

Ses        var TSession        This is a session instance variable that
you pass by reference into the procedure. Note: It MUST be instantiated
prior to use. The procedure does not create an instance. It assumes it
already exists. This is especially necessary when using this procedure
within a thread. But if you\'re not creating a multi-threaded
application, then you can use the default Session variable.

DBName       String        Name of the MS SQL Server client database

ArTables        Array of String        This is an open array of string
that you can pass into the procedure. This means that you can pass any
size array and the procedure will handle it. For instance, in the
Primary table maker program, I define an array as follows: 

    arPat[0] := 'dbo.Temp0';
    arPat[1] := 'dbo.Temp1';
    arPat[2] := 'dbo.Temp2';
    arPat[3] := 'dbo.Temp3';
    arPat[4] := 'dbo.Temp4';
    arPat[5] := 'dbo.Temp5';
    arPat[6] := 'dbo.PatList';
    arPat[7] := 'dbo.PatientList';
    arPat[8] := 'dbo.EpiList';
    arPat[9] := 'dbo.' + FDisease + 'CrossTbl_' + FQtrYr;
    arPat[10] := 'dbo.' + FDisease + 'Primary_' + FQtrYr;

and pass it into the procedure.

StatMsg        TStatusMsg        This is a procedural type of :
procedure(Msg : String). You can\'t use a class method for this
procedure; instead, you declare a regular procedure that references a
regular procedure. For example, I declare an interface-level procedure
called StatMsg that references a thread instance variable and a method
as follows: 

    procedure StatMsg(Msg: string); 
    begin   
    thr.FStatMsg := Msg;   
    thr.Synchronize(thr.UpdateStatus); 
    end;  

The trick here is that "thr" is the instance variable used to
instantiate my thread class. The instance variable resides in the main
form of my application. This means that it too must be declared as an
interface variable.

I\'m usually averse to using global variables and procedures. It\'s
against structured programming conventions. However, what this procedure
buys me is the ability to place it in a centralized library and utilize
it in all my programs.

Before you use this, please make sure you review the table above. You
need to declare a type of TStatusMsg prior to declaring the procedure.
If you don\'t, you\'ll get a compilation error.

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
