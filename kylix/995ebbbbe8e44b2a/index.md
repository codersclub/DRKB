---
Title: How do I create an executible file using the command line directive in Linux with Kylix?
Date: 01.01.2007
---


How do I create an executible file using the command line directive in Linux with Kylix?
========================================================================================

::: {.date}
01.01.2007
:::

How do I create an executable file, i.e. foo.exe, using dcc in Kylix?

Create the project file, i.e. foo.dpr, using VI, Pico or some other text
writing tool. Next, at the command line type: dcc foo. You can pass in
flags like -BE: dcc -BE foo, the will build and execute the file. There
are a number of different flags you can pass in, look at the help for
dcc for a full listing and description.

    program foo
     
    uses
      SysUtils;
     
    begin
      writeln('Hello World');
      readln;
    end.
