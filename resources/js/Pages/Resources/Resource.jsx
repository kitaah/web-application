import React from 'react';
import Layout from '@/Layouts/Layout';
import { usePage } from '@inertiajs/react';
import CommentForm from '../Comments/CommentForm.jsx';

export default function Resource() {
    const { resource, comments, auth, user } = usePage().props;

    return (
        <Layout header={<h2 className="font-semibold text-xl text-gray-800 leading-tight text-center">Ressource</h2>}>
            <div className="container mx-auto my-8">
                <h1 className="text-4xl font-bold mb-4 text-center">{resource.name}</h1>

                <section className="mb-8 text-center">
                    <div className="flex justify-center items-center">
                        <img src={resource.image} width="400" alt={resource.name}/>
                    </div>
                    <div>Url : <strong>{resource.url}</strong></div>
                    <br/>
                    <div>Description : <strong>{resource.description}</strong></div>
                    <br/>
                    <div>Catégorie : <strong>{resource.category_name}</strong></div>
                    <br/>
                    <div className="flex flex-col items-center justify-center">
                        <div>
                            Posté par : <strong>{resource.user_name}</strong>
                        </div>
                        <img
                            src={resource.user_image}
                            className="w-24 h-24 rounded-full mb-4 ml-4"
                            alt={resource.name}
                        />
                    </div>
                    <br/>
                    <div>Posté le : <strong>{resource.created_at}</strong></div>
                    <br/>
                    <div>Mise à jour le : <strong>{resource.updated_at}</strong></div>
                    <br/>

                    <div className="mt-8">
                        <h2 className="text-2xl font-bold mb-4">Commentaires</h2>
                        {comments.length === 0 ? (
                            <div className="text-gray-600">Aucun commentaire posté pour le moment</div>
                        ) : (
                            comments.map(comment => (
                                <div key={comment.id} className="border-b border-gray-300 mb-4 pb-4">
                                    <p className="text-gray-800">{comment.content}</p>
                                    <img src={comment.user_image} className="w-24 h-24 rounded-full mb-4"
                                         alt={comment.user_name}/>
                                    <p className="text-sm text-gray-600 mt-2">
                                        Posté par {comment.user_name} le {comment.created_at}
                                    </p>
                                </div>
                            ))
                        )}
                    </div>
                </section>
                {auth.user && auth.user.email_verified_at && user.permissions.includes("post a comment") && (
                    <CommentForm resourceId={resource.id}/>
                )}
            </div>
        </Layout>
    );
};
