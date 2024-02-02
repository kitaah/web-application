import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Game = () => {
    const [game, setGame] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get('https://web-application.ddev.site:8443/api/game'); // also works with /ap/game
                console.log('API Response:', response.data);

                setGame(response.data.data);
            } catch (error) {
                console.error('API Error:', error);
            }
        };

        fetchData().then(r => {});
    }, []);

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Quiz du jour</h1>

            <section className="mb-8">
                {game && (
                    <div>
                        <div>Titre: <strong>{game.name}</strong></div>
                        <div>Question: <strong>{game.question}</strong></div>
                        <div>Réponse: <strong>{game.is_right ? 'Oui' : 'Non'}</strong></div>
                    </div>
                )}
            </section>
        </div>
    );
};

export default Game;
