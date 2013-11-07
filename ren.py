#!/usr/bin/python3

import os
import sys


for name in sys.stdin.readlines():
    # Each line will have a newline on the end
    # that should be removed.
    name = name.strip()
    if sys.argv[1] in name:
        foo = name.replace(sys.argv[1],sys.argv[2])
        bar = "mv " + name + " ./" + foo 
        os.system(bar)
        #print(bar)
