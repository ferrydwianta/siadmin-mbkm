import { useState } from 'react';

export default function Description({ description }) {
    const [isExpanded, setIsExpanded] = useState(false);
    const MAX_LENGTH = 100;

    return (
        <div>
            <p className="text-sm">
                {isExpanded || description.length <= MAX_LENGTH
                    ? description
                    : `${description.slice(0, MAX_LENGTH)}...`}

                {description.length > MAX_LENGTH && (
                    <button onClick={() => setIsExpanded(!isExpanded)} className="text-sm font-medium text-blue-600">
                        &nbsp;{isExpanded ? 'Show Less' : 'Read More'}
                    </button>
                )}
            </p>
        </div>
    );
}
