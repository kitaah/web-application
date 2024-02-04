import { useState } from 'react';
import Layout from '@/Layouts/Layout';
import { usePage } from '@inertiajs/react';

export default function Game() {
    const { game } = usePage().props;
    const [selectedAnswer, setSelectedAnswer] = useState(null);
    const [feedbackMessage, setFeedbackMessage] = useState('');

    const handleAnswerClick = (isRight) => {
        setSelectedAnswer(isRight);
        setFeedbackMessage(isRight ? 'Bonne réponse' : 'Mauvaise réponse');
    };

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Jeu</h2>}>
            <div className="container mx-auto my-8 text-center">
                <h1 className="text-4xl font-bold mb-4 text-center">Quiz du jour</h1>

                <section className="mb-8">
                    {game && (
                        <div>
                            <div>Titre: <strong>{game.name}</strong></div>
                            <div>Question: <strong>{game.question}</strong></div>
                            <div className="hidden">Réponse: <strong>{game.is_right ? 'Vrai' : 'Faux'}</strong></div>

                            <div className="mt-4">
                                <button
                                    className={`px-6 py-2 mr-4 text-white bg-green-500 rounded-md focus:outline-none ${selectedAnswer === true ? 'bg-opacity-50 cursor-not-allowed' : ''}`}
                                    onClick={() => handleAnswerClick(true)}
                                    disabled={selectedAnswer !== null}
                                >
                                    Vrai
                                </button>
                                <button
                                    className={`px-6 py-2 text-white bg-red-500 rounded-md focus:outline-none ${selectedAnswer === false ? 'bg-opacity-50 cursor-not-allowed' : ''}`}
                                    onClick={() => handleAnswerClick(false)}
                                    disabled={selectedAnswer !== null}
                                >
                                    Faux
                                </button>
                            </div>

                            {selectedAnswer !== null && (
                                <div className={`mt-4 ${selectedAnswer ? 'text-green-500' : 'text-red-500'}`}>
                                    {feedbackMessage}
                                </div>
                            )}
                        </div>
                    )}
                </section>
            </div>
        </Layout>
    );
}
