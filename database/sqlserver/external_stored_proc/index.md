---
Title: Разработка внешних Stored Procedures
Date: 01.01.2007
---


Разработка внешних Stored Procedures
====================================

::: {.date}
01.01.2007
:::

Answer:

Writing MS SQL Server Extended Stored Procedures with Delphi

Microsoft SQL Server 6.5 and 7 have the powerful capability to make
functions in DLL\'s available as stored procedures. Microsoft calls them
Extended Stored Procedures. If you\'ve read this article, you know what
Extended Stored Procedures are, what you can do with them, and how to
install them on a SQL Server. You should also be able to use the
object-oriented framework I wrote, which makes writing Extended Stored
Procedures with Delphi extremely easy.

I assume you are familiar with SQL Server and with the concept of stored
procedures. The code and examples in this article apply both to SQL
Server 6.5 and SQL Server 7.

What are Extended Stored Procedures?

Extended Stored Procedures (called xp\'s afterwards) are part of
Microsoft\'s Open Data Services (ODS) for SQL Server. With ODS you can
do three things:

1.        Making routines in a DLL available as stored procedures to any
SQL Server user.

2.        Write procedure server applications. They are similar to
xp\'s, however they run as a separate network server application and
could even be running on a different machine (3-tier).

3.        Writing gateways to non-SQL Server based environments.

In the following figure a graphical overview of the ODS architecture is
given.

In this article I discuss the art of writing stored procedures with
Delphi. Technically this DLL is part of SQL server, therefore programmer
errors may corrupt your SQL Server, so it\'s not an art without danger.

Making parts of your application available on the server has some
advantages, for example:

1.        Some things are easy to write in Delphi, but difficult or
impossible using Transact SQL. For example you might use some routines
written in a language you don\'t understand or don\'t have the source
code for, so you can\'t translate it to Transact SQL (with the
possibility of errors creeping in during this translation).

2.        Delphi routines run much faster than Transact SQL. Take for
example numerical calculations.

3.        You can interface with other programs, databases and such. For
example you could write an xp that accepts the name of a paradox table
and returns the contents of this table as a SQL Server result set.

Xp\'s live in DLL\'s and can therefore be written in any language which
can produce DLL\'s like Delphi can. Before going into detail about how
to write xp\'s, first some examples from a user\'s point of view. Let\'s
assume we have an xp called xp\_incbyone1 which increments a given
number by one. We can call xp\_incbyone1 as followings:

            declare
              @mynumber integer
            select @mynumber = 1
            exec master..xp_incbyone1 @mynumber output
            select @mynumber

The declare statement declares a variable @mynumber of type integer.
Next we set it to one, pass it to the xp and allow the xp to modify it
by appending output to the parameter. Finally we display the number with
a select statement to see if it has been updated. The result should be 2
of course.

In this example we have an xp which returns an output parameter. Xp\'s
can also return a result set. The example xp\_incbyone2 returns the
number as a result set. The code to call it would be:

            declare
             @mynumber integer

            select @mynumber = 1

            exec master..xp_incbyone2 @mynumber

xp\_incbyone2 will return a table of just one column and one row
containing the value 1.

Both xp\_incbyone1 and xp\_incbyone2 are described in detail in the next
section where I present the framework.

As you see, for users extended stored procedures work exactly like
stored procedures. Just like stored procedures, extended stored
procedures can return parameters and/or result sets.

Each implementation of an xp needs to do the same things:

1.        Check that the caller of the procedure has provided all of the
required parameters and that each parameter is of the appropriate data
type. Return an appropriate message if not.

2.        Define the columns for returning a result set.

3.        Create each record for returning to the caller.

4.        Set up any output parameters and return statuses used by the
procedure.

5.        When finished returning results, send the results completion
message using srv\_senddone with the SRV\_DONE\_MORE status flag.

6.        Return from the procedure with the desired Transact-SQL return
status.

Step 1 is necessary because, unless normal stored procedures, it is up
to the programmer to validate any user-specified parameters for xp\'s.
Step 2 and 3 are optional, and are applicable only if you return a
result set. Step 4 is also optional, and applies only if you return
output parameters.

Writing xp\'s with Delphi

The C programmer who wants to develop xp\'s has to install the SQL
Server 7 development tools. This option can be turned on when installing
SQL Server 7. In the directory \\MSSQL7\\devtools\\ you will find all
the required header files and demo-programs. Unfortunately, Inprise did
not supply a translation of these header files with Delphi. Therefore I
had to translate the most important parts by hand to Delphi. This means
that you don\'t need to install the SQL Server 7 development tools if
you use this framework to write xp\'s. If you want to add more pieces
you will need this resource kit though. Or you can ask me if I\'ve time
to expand the framework a bit to cover the missing pieces. Note: in
previous version of SQL Server the development tools were part of the
the BackOffice resource kit.

In the previous paragraph 6 steps were mentioned each xp has to do. The
framework makes step 1 through 4 easier by taking care of details. You
also can use Delphi types, because the framework does type translation
between SQL Server types and Delphi types. The framework takes entirely
care off step 5 and 6.

You use this framework as follows:

1.        Create an object of class TSQLXProc and implement its Execute
method.

2.        Write a procedure that allocates this object, calls it\'s Run
method and frees the object. The name of this procedure should be equal
to the name of your extended stored procedure. It\'s calling method
should be stdcall.

To make this more concrete, let\'s implement the xp\_incbyone1 stored
procedure. The 1st step is to create a new object based on TSQLXProc and
implement its Execute method. It\'s header looks like this:

    type
      TXPIncByOne1 = class(TSQLXProc)
        function Execute: Boolean; override;
      end;
     
    The Execute method looks like this:
     
    function TXPIncByOne1.Execute: Boolean;
    begin
      Params[1] := Params[1] + 1;
      Result := True;
    end;

The 2nd step is to write a procedure that calls this object. This is the
procedure that SQL Server is actually calling. For xp\_incbyone1 it
looks like this:

    function xp_incbyone1(srvproc: PSRV_PROC): SRVRETCODE; stdcall;
    const
      ExpectedParams = 1;
    var
      xp: TSQLXProc;
    begin
      xp := TXPIncByOne1.Create(srvproc, ExpectedParams);
      Result := xp.Run;
      xp.Free;
    end;

It\'s that easy!

Let\'s look in more detail to the first step. The only thing you\'ll
ever need to do is to implement the Execute method. This function
returns True or False. If False is returned, an error is returned to the
calling application or user. Exceptions are caught by the code that
calls your Execute method and a similar error is returned to the calling
application or user.

You have access to the parameters of a stored procedure by using the
variant array Params. Parameters are numbered from one onwards. As noted
earlier SQL Server does no type checking on xp parameters. The framework
returns parameters as variants, so it\'s a bit more robust against
different parameters, but variant conversion errors may occur if a
parameter type mismatches. You might want to use the ODS API call
srv\_paramtype to explicitly retrieve and check parameter types, but so
far I\'ve not found a need this. Another solution for checking parameter
types is to use the VarType function. See Table 1 for a list of
Transact-SQL data types and corresponding Delphi data types.

If a parameter is Null, the Params property returns the variant type
Null. Equally, if you want to return Null, set the corresponding
parameter in Params to Null.

Let\'s look in more detail to the second step. This step will probably
always be the same except for the value of the ExpectedParams const and
the particular object to instantiate. This procedure is called by SQL
Server with one parameter: srvproc. We pass this parameter to the
instantiated object and we pass it the number of parameters to expect.
If the actual number of parameters is different from this an error
message will be send back to the calling application/user. Pass zero if
you don\'t want to check for the number of parameters, for example to
support a variable number of parameters.

Next we call the Run method of the instantiated object, which in turn
will call our Execute method (surrounded by for example a try..except
block). Finally we free the object.

Now let\'s tackle an xp which returns a result set. It\'s header is
this:

    type
      TXPIncByOne2 = class(TSQLXProc)
        function Execute: Boolean; override;
      end;

It\'s body is this:

    function TXPIncByOne2.Execute: Boolean;
    var
      myint: integer;
    begin
      DescribeColumn('my column name', SRVINT4, 4, SRVINT4, 4, @myint);
      Myint := Params[1] + 1;
      SendRow;
      Result := True;
    end;

And the procedure to call this object is this:

    function xp_incbyone2(srvproc: PSRV_PROC): SRVRETCODE; stdcall;
    const
      ExpectedParams = 1;
    var
      xp: TSQLXProc;
    begin
      xp := TXPIncByOne2.Create(srvproc, ExpectedParams);
      Result := xp.Run;
      xp.Free;
    end;

We now have a bit more complicated Execute method. In case we want to
return a result set, we need to describe every row in the resulting
table: its column name, its destination type, its destination length,
its source type, its source length and a pointer to the source data. You
should call DescribeColumn for every column in the result table. The
next step is to fill the source data, that\'s the assignment to myint.
The row is now complete, so we can send it to SQL Server using SendRow.
You should prepare source data and call SendRow for every row in the
result table. And finally just return True and exit. After that SQL
Server will send the entire result table to the client.

The xp\_incbyone2 procedure is still a simple call the object and exit.
In the remaining examples I will omit this procedure.

Table 1: supported types for use with DescribeColumn.

ODS constant         TSQL data type(s)        Delhi data type(s)      
SRVVARCHAR        varchar        string       SRVCHAR        char       
 string       SRVINTN        tinyint, smallint, int      
 shortint,smallint,integer       SRVBIT         bit        Boolean      
SRVDECIMAL        numeric/decimal        n/a (string)       SRVNUMERIC  
     numeric/decimal        n/a (string)       SRVFLTN        real,
float        single, double       SRVMONEYN        smallmoney, money    
   n/a (integer, DBMONEY)       SRVDATETIMN        smalldatetime,
datetime        TDateTime      

I implemented two xp\'s from the sample xp\'s which Microsoft
implemented in xp.c. The first one simply copies the contents of the
first parameter to the second parameter. The second one returns the free
space from every drive available on the SQL Server computer.

To avoid name clashes I called the first xp xp\_delphiecho instead of
xp\_echo. The second one is called xp\_delphidisklist instead of
xp\_disklist. Especially xp\_echo looks ways more elegant than the
Microsoft\'s sample program. You really should have a look at xp.c!

The code for xp\_delphiecho is:

    function TXPEcho.Execute: Boolean;
    begin
      Params[2] := Params[1];
      Result := True;
    end;

The code for xp\_delphidisklist is:

     
    function TXPDiskList.Execute: Boolean;
    var
      drivename: char;
      space_remaining: Int32;
      drivenums: Int32;
      rootname: string;
      SectorsPerCluster,
        BytesPerSector,
        NumberOfFreeClusters,
        TotalNumberOfClusters: dword;
     
      function IsDrive(drive: char): Boolean;
      begin
        IsDrive := (drivenums and (1 shl (Ord(drive) - Ord('A')))) <> 0;
      end;
     
    begin
      DescribeColumn('drive', SRVCHAR, 1, SRVCHAR, 1, @drivename);
      DescribeColumn('bytes free', SRVINT4, 4, SRVINT4, 4, @space_remaining);
      drivenums := GetLogicalDrives;
      for drivename := 'C' to 'Z' do
      begin
        if IsDrive(drivename) then
        begin
          rootname := drivename + ':\';
          GetDiskFreeSpace(
            PChar(rootname),
            SectorsPerCluster,
            BytesPerSector,
            NumberOfFreeClusters,
            TotalNumberOfClusters);
          space_remaining := SectorsPerCluster * NumberOfFreeClusters * BytesPerSector;
          SendRow;
        end;
      end;
      Result := True;
    end;

In the first two lines the description of the result table is given. The
result table consists of two columns \'drive\' and \'bytes free\'. Next
for every drive we fill the variables drivename and space\_remaining and
send back the row using SendRow.

The framework in more detail

The framework itself is in the unit odsxp.pas. In the following figure
you see how this framework fits within the ODS architecture. 

SQL Server loads and calls the DLL. You have written a simple method
which creates an object of type TSQLXProc. You call its Run method.

The Run method does some checks and calls you back on a method you have
written, the Execute method. When you are finished, you return to Run,
which in return sends the results back to SQL Server.

Installing xp\'s on SQL Server

All of the material in this section can also be found in the Microsoft
SQL Programmers Toolkit or in the Microsoft Transact-SQL reference.

Installing xp\'s differs between SQL Server 6.5 and SQL Server 7.0.
Everything that works under SQL Server 6.5 also works under SQL Server
7.

Installing xp\'s on SQL Server 7

Installing an extended stored procedure on SQL Server 7 can be done
using the SQL Enterprise manager:

1.        Open a server.

2.        Go to item \`Databases\'.

3.        Select the master database.

4.        Right click it and choose \`New Extended Stored Procedure\',
see figure below

5.        Give the name of a function in the DLL and the location and
name of the DLL itself.

Installing xp\'s on SQL Server 6.5

When you have compiled your DLL you have to install it in the
appropriate directory. Copy the file to the same directory as the
standard SQL Server DLL files. Usually this directory is something like
c:\\mssql\\binn, note binn with two n\'s not the bin directory with a
single n which also exists! As with other DLL\'s, once the extended
stored procedure DLL is placed in the appropriate directory and the
appropriate paths are set, you can make its functions available to users
immediately. It is not necessary to restart the server.

For each function provided in an extended stored procedure DLL, a SQL
Server system administrator must run the sp\_addextendedproc system
procedure, specifying the name of the function and the name of the DLL
in which that function resides. For example:

sp\_addextendedproc \'xp\_delphiecho\', \'xpdelphi.dll\'

This command registers the function xp\_delphiecho, located in the file
xpdelphi.dll, as a SQL Server extended stored procedure. You must run
sp\_addextendedproc in the master database.

To drop individual extended stored procedures, a system administrator
uses the system procedure sp\_dropextendedproc.

Once a system administrator has added an extended stored procedure,
users can find out what new functions are available by using the system
procedure sp\_helpextendedproc. When used without an argument,
sp\_helpextendedproc displays all extended stored procedures that are
currently registered with the master database. If you specify an
extended stored procedure name as an argument, sp\_helpextendedproc
verifies whether that function is currently available.

Extended Stored Procedures are subject to the same security mechanisms
as regular stored procedure. For example to give every right on the
xp\_delphiecho xp, run the following command in the master database:

       grant exec on xp\_delphiecho to public

Calling extended stored procedures

Every user can now call xp\_delphiecho from every database by prefixing
xp\_delphiecho with \'master..\'. For example to call xp\_delphiecho
from the pubs database you say:

       exec master..xp_delphiecho @paramin, @paramout output

Unloading extended stored procedures

SQL Server loads an extended stored procedure DLL as soon as a call is
made to one of the DLL\'s functions. The DLL remains loaded until the
server is shut down or until the system administrator uses the DBCC
command to unload it. For example:

DBCC xpdelphi(FREE)

This command unloads xpdelphi.dll, allowing the system administrator to
copy in a newer version of this file without shutting down the server.
You probably will need this command quite a lot to debug your xp\'s!

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
