import { usePage } from '@inertiajs/react';

export default function Game() {
    const { game } = usePage().props;

    return (
        <div className="container mx-auto my-8 text-center">
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
