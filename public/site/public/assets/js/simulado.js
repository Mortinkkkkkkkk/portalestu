const questions = {
    matematica: [
        { pergunta: "Qual é a derivada de x²?", opcoes: ["2x", "x²", "x", "2"], resposta: "2x" },
        { pergunta: "Qual é o valor de 5 + 7?", opcoes: ["12", "11", "13", "10"], resposta: "12" },
        { pergunta: "Quanto é a raiz quadrada de 16?", opcoes: ["4", "5", "6", "7"], resposta: "4" },
        { pergunta: "Qual é o valor de 3 x 3?", opcoes: ["9", "6", "12", "3"], resposta: "9" },
        { pergunta: "Qual é a integral de x?", opcoes: ["x²/2 + C", "x²", "2x", "1/x"], resposta: "x²/2 + C" },
    ],
    linguagens: [
        { pergunta: "Quem escreveu 'Dom Casmurro'?", opcoes: ["Machado de Assis", "José de Alencar", "Jorge Amado", "Carlos Drummond"], resposta: "Machado de Assis" },
        { pergunta: "Qual é o gênero textual do poema?", opcoes: ["Narrativo", "Descritivo", "Poético", "Argumentativo"], resposta: "Poético" },
        { pergunta: "O que é uma metáfora?", opcoes: ["Comparação implícita", "Figura de som", "Rima", "Metonímia"], resposta: "Comparação implícita" },
        { pergunta: "Qual a função da linguagem em um poema?", opcoes: ["Expressiva", "Referencial", "Conativa", "Fática"], resposta: "Expressiva" },
        { pergunta: "Quem é o autor de 'O Primo Basílio'?", opcoes: ["Machado de Assis", "Eça de Queirós", "Aluísio Azevedo", "Raquel de Queirós"], resposta: "Eça de Queirós" },
    ],
    ciencias_natureza: [
        { pergunta: "Qual é a fórmula química da água?", opcoes: ["H2O", "CO2", "NaCl", "O2"], resposta: "H2O" },
        { pergunta: "Qual é a principal fonte de energia do planeta?", opcoes: ["Sol", "Vento", "Água", "Carvão"], resposta: "Sol" },
        { pergunta: "Quem desenvolveu a teoria da relatividade?", opcoes: ["Einstein", "Newton", "Galileu", "Bohr"], resposta: "Einstein" },
        { pergunta: "Qual é o gás mais abundante na atmosfera?", opcoes: ["Nitrogênio", "Oxigênio", "CO2", "Hélio"], resposta: "Nitrogênio" },
        { pergunta: "O que é fotossíntese?", opcoes: ["Processo de produção de energia nas plantas", "Absorção de água", "Respiração celular", "Nutrição"], resposta: "Processo de produção de energia nas plantas" },
    ],
    ciencias_humanas: [
        { pergunta: "Em que ano começou a Segunda Guerra Mundial?", opcoes: ["1939", "1945", "1914", "1929"], resposta: "1939" },
        { pergunta: "Quem foi o líder da independência da Índia?", opcoes: ["Gandhi", "Mandela", "Luther King", "Castro"], resposta: "Gandhi" },
        { pergunta: "Em que ano foi proclamada a República no Brasil?", opcoes: ["1889", "1822", "1922", "1930"], resposta: "1889" },
        { pergunta: "Quem descobriu o Brasil?", opcoes: ["Pedro Álvares Cabral", "Cristóvão Colombo", "Américo Vespúcio", "Fernão de Magalhães"], resposta: "Pedro Álvares Cabral" },
        { pergunta: "Onde ocorreram as primeiras civilizações?", opcoes: ["Mesopotâmia", "Roma", "China", "Egito"], resposta: "Mesopotâmia" },
    ]
};

let selectedQuestions = [];

function getRandomQuestions() {
    selectedQuestions = [];
    for (const disciplina in questions) {
        let shuffled = questions[disciplina].sort(() => 0.5 - Math.random());
        selectedQuestions.push(...shuffled.slice(0, 5));
    }
    selectedQuestions = selectedQuestions.sort(() => 0.5 - Math.random());
}

function renderQuiz() {
    getRandomQuestions();
    const quizDiv = document.getElementById("quiz");
    quizDiv.innerHTML = "";
    
    selectedQuestions.forEach((q, index) => {
        const questionDiv = document.createElement("div");
        questionDiv.classList.add("question");
        questionDiv.innerHTML = `
            <h3>${index + 1}. ${q.pergunta}</h3>
            <div class="options">
                ${q.opcoes.map(opcao => `
                    <label>
                        <input type="radio" name="question${index}" value="${opcao}">
                        ${opcao}
                    </label>
                `).join('')}
            </div>
        `;
        quizDiv.appendChild(questionDiv);
    });
}

function submitQuiz() {
    let acertos = 0;
    const totalPerguntas = selectedQuestions.length;
    let gabaritoHTML = "";

    selectedQuestions.forEach((q, index) => {
        const selectedOption = document.querySelector(`input[name="question${index}"]:checked`);
        const isCorrect = selectedOption && selectedOption.value === q.resposta;

        if (isCorrect) acertos++;

        gabaritoHTML += `
            <p class="${isCorrect ? 'correct' : 'incorrect'}">
                Questão ${index + 1}: ${q.pergunta}<br>
                Sua resposta: ${selectedOption ? selectedOption.value : "Nenhuma"}<br>
                Correta: ${q.resposta}
            </p>
        `;
    });

    document.getElementById("result").innerHTML = `Você acertou ${acertos} de ${totalPerguntas} perguntas.`;
    document.getElementById("answerKey").innerHTML = `<h2>Gabarito</h2>${gabaritoHTML}`;
}

renderQuiz();
