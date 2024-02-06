import Layout from '@/Layouts/Layout';
import { useState } from 'react';
import { usePage } from '@inertiajs/react';
import axios from 'axios';

export default function Association() {
    const { association, auth } = usePage().props;
    const [voted, setVoted] = useState(false);

    const handleVote = async () => {
        try {
            await axios.post(`/association/${association.slug}/vote`);
        } catch (error) {
            console.error('Error voting:', error.response);
        }
    };

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Association</h2>}>
            <div className="container mx-auto my-8 text-center">
                <h1 className="text-4xl font-bold mb-4 text-center">{association.name}</h1>

                <section className="mb-8 flex items-center justify-center">
                    {association && (
                        <div>
                            <div className="flex justify-center items-center">
                                <img src={association.image} width="150" alt={association.name} />
                            </div>
                            <div>Catégorie: <strong>{association.category_name}</strong></div>< br />
                            <div>
                            <a href={association.url} className="px-6 py-2 mx-5 text-white bg-blue-500 rounded-md focus:outline-none" target="_blank" rel="noopener noreferrer">
                                Voir le site
                            </a></div>< br />
                            <div>Ville: <strong>{association.city}</strong></div>< br />
                            <div>Description: <strong>{association.description}</strong></div>< br />
                            <div>Projet: <strong>{association.project}</strong></div>< br/>
                            {auth.user && (
                            <div>
                                {/* Your existing UI */}
                                <button
                                    onClick={handleVote}
                                    className="px-6 py-2 mt-4 text-white bg-green-500 rounded-md focus:outline-none"
                                >
                                    Vote pour cette association
                                </button>
                            </div>
                                )}
                            {!auth.user && (
                                <div className="font-bold">Si tu souhaites voter pour cette association inscris toi dès maintenant !</div>
                            )}
                        </div>
                    )}
                </section>
            </div>
        </Layout>
    );
}
