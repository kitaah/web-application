import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Resources = () => {
    const [resources, setResources] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get('https://web-application.ddev.site:8443/api/resources'); // works also with /api/resources only
                console.log('API Response:', response.data);

                if (Array.isArray(response.data.data)) {
                    setResources(response.data.data);
                } else {
                    console.error('Invalid response format. Expected an array in "data".');
                }
            } catch (error) {
                console.error('API Error:', error);
            }
        };

        fetchData().then(r => {});
    }, []);

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Liste des ressources</h1>

            <section className="mb-8">
                <h2 className="text-2xl font-bold mb-2 text-center">Consultez la liste des ressources</h2>
                <ul className="mb-2">
                    {resources.map(({category_name, description, id, image, name, slug, url, user_name, created_at, updated_at}) => (
                        <li key={id}>
                            <div>Titre:<strong>{name}</strong></div>< br />
                            <div>Url:<strong>{url}</strong></div>< br />
                            <div>Description:<strong>{description}</strong></div>< br />
                            <div>Slug:<strong>{slug}</strong></div>< br />
                            <div>Catégorie:<strong>{category_name}</strong></div>< br />
                            <div>Posté par:<strong>{user_name}</strong></div>< br />
                            <div>Posté le:<strong>{created_at}</strong></div>< br />
                            <div>Mise à jour le:<strong>{updated_at}</strong></div>< br />
                            <img src={image} alt={name} />
                        </li>
                    ))}
                </ul>
            </section>
        </div>
    );
};

export default Resources;
