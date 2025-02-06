var elements = document.getElementsByTagName("p");
console.log(elements);
for (var i = 0; i < elements.length; i++) {
    elements[i].style.fontSize = "50px";
}

var sentenceElement = document.getElementsByClassName("sentence");
console.log(sentenceElement);

// Variables
var a = 5;
let b = 5;

// Constants
const fontSize = "10px";

// Arithmetic Operators + - * / %


// Logical Operators 


// Boolean Operators

// Conditional Statements


const isPrime = async (n) => {
    for (var i = 2; i < n; i++) {
        if (n % i == 0) {
            return false;
        }
    }
    return true;
}

async function countPrime(n) {
    let prime = 0;
    var i = 2;
    while (i <= n) {
        if (isPrime(i)) {
            prime += 1;
        }
        i++;
    }
    return prime;
}
//  onclick="alert('Clicked!')"
console.log(countPrime(100));

// document.getElementById("click").onclick = () => {
//     alert("Clicked!");
// }

// let sentenceElement = document.getElementsByClassName("sentence");
sentenceElement.onclick = () => {
    alert("Cicked!");
};
console.log(sentenceElement);

var elements = document.getElementById("sentence");
console.log(elements);

var buttonElement = document.getElementsByClassName("button");
console.log("button");
console.log(buttonElement);
buttonElement.onclick = () => {
    alert("Clicked!");
}

// buttonElement.addEventListener("click", () => {
//     alert("Clicked!");
// })

let buttonOnClick = () => {
    alert("Clicked!");
}