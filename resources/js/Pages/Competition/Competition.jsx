import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Competition = () => {
    const [competition, setCompetition] = useState([]);
    const [selectedAssociation, setSelectedAssociation] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get('https://web-application.ddev.site:8443/api/competition');
                console.log('API Response:', response.data);

                if (Array.isArray(response.data.data)) {
                    setCompetition(response.data.data);
                } else {
                    console.error('Invalid response format. Expected an array in "data".');
                }
            } catch (error) {
                console.error('API Error:', error);
            }
        };

        fetchData().then(r => {});
    }, []);

    const handleDetailsClick = (association) => {
        setSelectedAssociation(association);
    };

    return (
        <div className="container mx-auto my-8">
            <h1 className="text-4xl font-bold mb-4 text-center">Compétition</h1>

            <div className="text-3xl font-bold mb-4 text-center">Inscrit toi pour pouvoir voter!</div>

            <section className="mb-8">
                <ul className="mb-2">
                    {competition.map(({ id, name, competition, association_first, association_second, association_third }) => (
                        <div key={id}>
                            <h2 className="text-center font-bold mb-2 text-center"><strong>{name}</strong></h2><br />
                            <div className="text-center font-bold mb-2">Budget: {competition.budget}</div><br />
                            <div className="text-center font-bold mb-2">Dates: {competition.start_date} au {competition.end_date} </div><br />
                            <div>
                                <div className="relative overflow-x-auto">
                                    <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" className="px-6 py-3">
                                                Nom
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                Image
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                Points
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                Détails
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {association_first.name}
                                            </th>
                                            <td className="px-6 py-4">
                                                <img src={association_first.image} width={100} alt={name} />
                                            </td>
                                            <td className="px-6 py-4">
                                                {association_first.points}
                                            </td>
                                            <td className="px-6 py-4">
                                                <button onClick={() => handleDetailsClick(association_first)}>Détails</button>
                                            </td>
                                        </tr>
                                        <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {association_second.name}
                                            </th>
                                            <td className="px-6 py-4">
                                                <img src={association_second.image} width={100} alt={name} />
                                            </td>
                                            <td className="px-6 py-4">
                                                {association_second.points}
                                            </td>
                                            <td className="px-6 py-4">
                                                <button onClick={() => handleDetailsClick(association_second)}>Détails</button>
                                            </td>
                                        </tr>
                                        <tr className="bg-white dark:bg-gray-800">
                                            <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {association_third.name}
                                            </th>
                                            <td className="px-6 py-4">
                                                <img src={association_third.image} width={100} alt={name} />
                                            </td>
                                            <td className="px-6 py-4">
                                                {association_third.points}
                                            </td>
                                            <td className="px-6 py-4">
                                                <button onClick={() => handleDetailsClick(association_third)}>Détails</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {selectedAssociation && (
                                <div className="text-center mt-2">
                                    <ul>
                                        <li>{selectedAssociation.name}</li>< br/>
                                        <li className="flex items-center justify-center"><img src={selectedAssociation.image} width={50} alt={name} /></li>< br/>
                                        <li className="font-bold">Ville: {selectedAssociation.city}</li>< br/>
                                        <li className="font-bold">Description : {selectedAssociation.description}</li>< br/>
                                        <li className="font-bold">Projet : {selectedAssociation.project}</li>< br/>
                                    </ul>
                                </div>
                            )}
                        </div>
                    ))}
                </ul>
            </section>
        </div>
    );
};

export default Competition;
