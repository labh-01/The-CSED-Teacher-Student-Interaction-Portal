x = 5
y = 10
z = 22
if x>y:
    print('x is smaller than y')
elif x < z:
    print('x is greater than 22')
elif 5<2:
    print('5 is greater than 2')
def examp():
    for x in range(1,10):
        print("hare krishna")
examp()
def fileWrite():
    text = 'A good day to you\nand wish you a happy life'
    str1 = open('new.txt','r').readlines()
    print(str1)

fileWrite()
