---
Title: Как использовать параметр в Format больше одного раза?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как использовать параметр в Format больше одного раза?
======================================================

Sometimes you probably have written something like this:

    s := Format('Hello %s, your name is %s %s', [FirstName, FirstName, LastName]);

(an admittedly stupid example ;-) )

And if you do, you probably found it annoying that you need to specify
the FirstName parameter twice, in particular if there are lots of
similar lines. But this isn\'t necessary because you can specify the
parameter position to use for the placeholder

in the format string like this:

    s := Format('Hello %0:s, your name is %0:s %1:s', [FirstName, LastName]);

Just one more example from a code generator I am currently writing:

    TableName := 'Customer';
    ...
    s := Format(' f%0:sTableAuto := T%0:sTableAuto.Create(f%0:Table);', [TableName]);

which results in

    s := ' fCustomerTableAuto := TCustomerTableAuto.Create(fCustmerTable);';

